<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\ShopStatisticsResource;
use App\Http\Resources\CustomerStatisticsResource;

use App\Models\Shop;
use App\Models\User;
use App\Models\Role;

class StatisticController extends Controller
{
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
