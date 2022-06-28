<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Http\Requests\CreateVisitorRequest;
use App\Models\Visitor;
use Illuminate\Http\Request;

use App\Http\Resources\ShopStatisticsResource;
use App\Http\Resources\CustomerStatisticsResource;
use App\Http\Resources\VisitorAmountListResource;

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
        $visitorsAmount = Visitor::select(DB::raw('created_at as date, count(*) as amount'))
        ->groupBy('date')
        ->get();
        return new VisitorAmountListResource($visitorsAmount);
    }

    public function getShopStatistics() {
        $shops = Shop::all();
        return new ShopStatisticsResource($shops);
    }

    public function getCustomerStatistics() {
        $customer_role_id = Role::where('name', 'customer')->first()->id;
        $users = User::where('role_id', $customer_role_id)->get();
        return new CustomerStatisticsResource($users);
    }

    public function getVisitorsAmountToday()
    {
        return response()->json([
            'amount' => random_int(10, 100),
        ]);
    }

    public function getVisitorsAmountMonth()
    {
        return response()->json([
            'amount' => random_int(10, 100),
        ]);
    }
}
