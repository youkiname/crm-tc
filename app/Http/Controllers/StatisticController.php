<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Http\Requests\CreateVisitorRequest;
use App\Models\Visitor;
use Illuminate\Http\Request;

use App\Http\Resources\ShopStatisticsResource;
use App\Http\Resources\CustomerStatisticsResource;
use App\Http\Resources\GraphListResource;

use App\Models\Shop;
use App\Models\User;
use App\Models\Role;

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
        $collection = Visitor::select(DB::raw('created_at as date, count(*) as amount'))
        ->when($request->start_date, function ($query, $startDate) {
            $query->where('created_at', '>=', $startDate);
        })
        ->when($request->end_date, function ($query, $endDate) {
            $query->where('created_at', '<=', $endDate);
        })
        ->groupBy('date')
        ->get();
        return new GraphListResource($collection);
    }

    public function getShopStatistics(Request $request) {
        $shops = Shop::where('shopping_center_id', 1)
        ->when($request->q, function ($query, $searchQuery) {
            $query->where('name', 'LIKE', '%' . $searchQuery . '%');
        });
        $shops = $this->tryAddPaginationAndLimit($shops, $request);
        return new ShopStatisticsResource($shops);
    }

    public function getCustomerStatistics(Request $request) {
        $customer_role_id = Role::where('name', 'customer')->first()->id;
        $customers = User::where('role_id', $customer_role_id);
        $customers = $this->tryAddPaginationAndLimit($customers, $request);
        return new CustomerStatisticsResource($customers);
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
}
