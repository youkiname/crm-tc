<?php

namespace App\Http\Controllers;

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
    public function storeVisitor(CreateVisitorRequest $request){
        $visitor = Visitor::create([
            'user_id' => $request->user_id,
            'shopping_center_id' => $request->shopping_center_id,
        ]);
        return response()->json([
            'success' => true,
        ]);
    }

    public function getVisitorsGraph(Request $request){
        return $this->getVisitorsGraphData($request->start_date, $request->end_date);
    }

    public function getVisitorsGraphMonth(Request $request){
        return $this->getVisitorsGraphData(Carbon::now()->subDays(30));
    }

    public function getShopStatistics(Request $request) {
        $shops = Shop::where('shopping_center_id', $request->user()->shoppingCenter()->id)
        ->when($request->q, function ($query, $searchQuery) {
            $query->where('name', 'LIKE', '%' . $searchQuery . '%');
        });
        $shops = $this->tryAddPaginationAndLimit($shops, $request);
        return new ShopStatisticsResource($shops);
    }

    public function getCustomerStatistics(Request $request) {
        $customer_role_id = Role::where('name', 'customer')->first()->id;
        $customers = User::where('role_id', $customer_role_id)
        ->when($request->q, function ($query, $searchQuery) {
            $query->where('first_name', 'LIKE', '%' . $searchQuery . '%');
        });
        $customers = $this->tryAddPaginationAndLimit($customers, $request);
        return new CustomerStatisticsResource($customers);
    }

    public function getSellerStatistics(Request $request) {
        $shop = $request->user()->shop;

        $seller_role_id = Role::where('name', 'seller')->first()->id;
        $sellers = User::where('role_id', $seller_role_id)
        ->when($request->q, function ($query, $searchQuery) {
            $query->where('first_name', 'LIKE', '%' . $searchQuery . '%');
        })
        ->whereRaw("exists (select seller_shop_bundles.id from seller_shop_bundles
        where seller_shop_bundles.seller_id = users.id AND seller_shop_bundles.shop_id = ?)
        ", [$shop->id]);
        $sellers = $this->tryAddPaginationAndLimit($sellers, $request);
        return new SellerStatisticsResource($sellers);
    }

    public function getVisitorsAmountToday()
    {
        $amount = Visitor::whereDate('created_at', Carbon::today())->count();
        return response()->json([
            'amount' => $amount,
        ]);
    }

    public function getVisitorsAmountMonth()
    {
        $amount = Visitor::where('created_at', '>=', Carbon::now()->subDays(30))
        ->count();
        return response()->json([
            'amount' => $amount,
        ]);
    }

    public function getVisitorsAgePlot()
    {
        return $this->getVisitorsAgePlotData();
    }

    public function getVisitorsAgePlotWeek()
    {
        return $this->getVisitorsAgePlotData(Carbon::now()->subDays(7));
    }

    public function getVisitorsAgePlotMonth()
    {
        return $this->getVisitorsAgePlotData(Carbon::now()->subDays(30));
    }

    public function getVisitorsAgePlotYear()
    {
        return $this->getVisitorsAgePlotData(Carbon::now()->subDays(365));
    }

    private function getVisitorsGraphData($startDate=null, $endDate=null) {
        $collection = Visitor::select(DB::raw('created_at as date, count(*) as amount'))
        ->when($startDate, function ($query, $startDate) {
            $query->where('created_at', '>=', $startDate);
        })
        ->when($endDate, function ($query, $endDate) {
            $query->where('created_at', '<=', $endDate);
        })
        ->groupBy('date')
        ->get();
        return new GraphListResource($collection);
    }

    private function getVisitorsAgePlotData($startDate=null) {
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
            ->whereRaw('year(now()) - year(users.birth_date) between ? AND ?', [$ageGroup[0], $ageGroup[1]])
            ->count();
            array_push($plotData, [
                'group' => sprintf("%d-%d", $ageGroup[0], $ageGroup[1]),
                'amount' => $amount,
            ]);
        }
        $genderRate = $this->getVisitorsGenderRate($startDate);
        return response()->json([
            'plot' => $plotData,
            'male_rate' => $genderRate['male'],
            'female_rate' => $genderRate['female'],
            'average_check' => $this->getAverageCheck($startDate),
        ]);
    }

    private function getVisitorsGenderRate($startDate=null) {
        $all = Visitor::when($startDate, function ($query, $startDate) {
            $query->where('created_at', '>=', $startDate);
        })->count();
        $visitorGenders = Visitor::select("users.gender", DB::RAW("count(*) as amount"))
        ->join('users', 'visitors.user_id', '=', 'users.id')
        ->when($startDate, function ($query, $startDate) {
            $query->where('visitors.created_at', '>=', $startDate);
        })
        ->groupBy('gender')
        ->get();
        $result = ['male' => 0, 'female' => 0];
        foreach ($visitorGenders as $gender) {
            $result[$gender->gender] = round($gender->amount / $all, 2);
        }
        return $result;
    }

    private function getAverageCheck($startDate=null) {
        $transactionsAmount = Transaction::when($startDate, function ($query, $startDate) {
            $query->where('created_at', '>=', $startDate);
        })->count();
        if ($transactionsAmount == 0) {
            return 0;
        }
        $transactionsSum = Transaction::when($startDate, function ($query, $startDate) {
            $query->where('created_at', '>=', $startDate);
        })->sum('amount');
        return round($transactionsSum / $transactionsAmount, 2);
    }
}
