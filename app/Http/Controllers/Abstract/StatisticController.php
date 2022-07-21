<?php

namespace App\Http\Controllers\Abstract;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Http\Requests\CreateVisitorRequest;
use App\Models\Visitor;
use Illuminate\Http\Request;

use App\Http\Resources\ShopStatisticsResource;
use App\Http\Resources\CustomerStatisticsResource;
use App\Http\Resources\SellerStatisticsResource;
use App\Http\Resources\GraphListResource;

use App\Models\Shop;
use App\Models\User;
use App\Models\Role;
use App\Models\Transaction;

class StatisticController extends Controller
{
    public function storeVisitor(CreateVisitorRequest $request) {
        $visitor = Visitor::create([
            'user_id' => $request->user_id,
            'shopping_center_id' => $request->shopping_center_id,
        ]);
        return $this->jsonSuccess();
    }

    public function getVisitorsAmountToday(Request $request)
    {
        $amount = Visitor::whereDate('created_at', Carbon::today())
        ->when($request->shopping_center_id, function ($query, $shopping_center_id) {
            $query->where('shopping_center_id', $shopping_center_id);
        })
        ->count();
        return response()->json([
            'amount' => $amount,
        ]);
    }

    public function getVisitorsAmountMonth(Request $request)
    {
        $amount = Visitor::where('created_at', '>=', Carbon::now()->subDays(30))
        ->when($request->shopping_center_id, function ($query, $shoppingCenterId) {
            $query->where('shopping_center_id', $shoppingCenterId);
        })
        ->count();
        return response()->json([
            'amount' => $amount,
        ]);
    }

    protected function _getCustomerStatistics($shoppingCenterId=null, $shopId=null) {
        $customer_role_id = Role::where('name', 'customer')->first()->id;

        $customers = User::where('role_id', $customer_role_id)
        ->when($shoppingCenterId, function ($query, $shoppingCenterId) {
            $query->whereRaw("
            exists (select * from transactions
            where transactions.shopping_center_id = ?
            AND transactions.customer_id = users.id)
            ", [$shoppingCenterId]);
        })
        ->when($shopId, function ($query, $shopId) {
            $query->whereRaw("
            exists (select * from transactions
            where transactions.shop_id = ?
            AND transactions.customer_id = users.id)
            ", [$shopId]);
        });
        return new CustomerStatisticsResource($customers->get());
    }

    protected function _getSellerStatistics($shopId=null) {
        $seller_role_id = Role::where('name', 'seller')->first()->id;

        $sellers = User::where('role_id', $seller_role_id)
        ->whereRaw("exists (select seller_shop_bundles.id from 
        seller_shop_bundles
        where seller_shop_bundles.seller_id = users.id 
        AND seller_shop_bundles.shop_id = ?)
        ", [$shopId]);
        return new SellerStatisticsResource($sellers->get());
    }

    protected function _getShopStatistics($shoppingCenterId=null) {
        $shops = Shop::when($shoppingCenterId, function ($query, $shoppingCenterId) {
            $query->where('shopping_center_id', $shoppingCenterId);
        });
        return new ShopStatisticsResource($shops->get());
    }

    protected function _getVisitorsGraphData($startDate=null, $endDate=null, $shoppingCenterId=null) {
        $collection = Visitor::select(DB::raw('created_at as date, count(*) as amount'))
        ->when($startDate, function ($query, $startDate) {
            $query->where('created_at', '>=', $startDate);
        })
        ->when($endDate, function ($query, $endDate) {
            $query->where('created_at', '<=', $endDate);
        })
        ->when($shoppingCenterId, function ($query, $shoppingCenterId) {
            $query->where('shopping_center_id', $shoppingCenterId);
        })
        ->groupBy('date')
        ->get();
        return new GraphListResource($collection);
    }

    protected function _getVisitorsAgePlotData($startDate=null, $shoppingCenterId=null) {
        $ageGroups = [
            [0, 17],
            [18, 24],
            [25, 30],
            [31, 35],
            [36, 40],
            [41, 45],
            [46, 50],
        ];
        $plotData = [];
        foreach ($ageGroups as $ageGroup) {
            $amount = Visitor::select("visitors.created_at, visitors.user_id, year(now()) - year(users.birth_date) as age")
            ->join('users', 'visitors.user_id', '=', 'users.id')
            ->when($startDate, function ($query, $startDate) {
                $query->where('visitors.created_at', '>=', $startDate);
            })
            ->when($shoppingCenterId, function ($query, $shoppingCenterId) {
                $query->where('visitors.shopping_center_id', $shoppingCenterId);
            })
            ->whereRaw('year(now()) - year(users.birth_date) between ? AND ?', [$ageGroup[0], $ageGroup[1]])
            ->count();
            array_push($plotData, [
                'group' => sprintf("%d-%d", $ageGroup[0], $ageGroup[1]),
                'amount' => $amount,
            ]);
        }
        $genderRate = $this->getVisitorsGenderRate($startDate, $shoppingCenterId);
        return response()->json([
            'plot' => $plotData,
            'male_rate' => $genderRate['male'],
            'female_rate' => $genderRate['female'],
            'average_check' => $this->getAverageCheck($startDate),
        ]);
    }

    private function getVisitorsGenderRate($startDate=null, $shoppingCenterId=null) {
        $all = Visitor::when($startDate, function ($query, $startDate) {
            $query->where('created_at', '>=', $startDate);
        })->count();
        $visitorGenders = Visitor::select("users.gender", DB::RAW("count(*) as amount"))
        ->join('users', 'visitors.user_id', '=', 'users.id')
        ->when($startDate, function ($query, $startDate) {
            $query->where('visitors.created_at', '>=', $startDate);
        })
        ->when($shoppingCenterId, function ($query, $shoppingCenterId) {
            $query->where('visitors.shopping_center_id', $shoppingCenterId);
        })
        ->groupBy('gender')
        ->get();
        $result = ['male' => 0, 'female' => 0];
        foreach ($visitorGenders as $gender) {
            $result[$gender->gender] = round($gender->amount / $all, 2);
        }
        return $result;
    }

    private function getAverageCheck($startDate=null, $shoppingCenterId=null, $shopId=null) {
        $transactionsQuery = Transaction::when($startDate, function ($query, $startDate) {
            $query->where('created_at', '>=', $startDate);
        })
        ->when($shoppingCenterId, function ($query, $shoppingCenterId) {
            $query->where('shopping_center_id', $shoppingCenterId);
        })
        ->when($shopId, function ($query, $shopId) {
            $query->where('shop_id', $shopId);
        });
        
        $transactionsAmount = $transactionsQuery->count();
        if ($transactionsAmount == 0) {
            return 0;
        }
        $transactionsSum = $transactionsQuery->sum('amount');
        return round($transactionsSum / $transactionsAmount, 2);
    }
}
