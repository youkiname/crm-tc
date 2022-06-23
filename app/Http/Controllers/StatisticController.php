<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\ShopStatisticsResource;
use App\Http\Resources\CustomerStatisticsResource;

use App\Models\Shop;
use App\Models\User;

class StatisticController extends Controller
{
    public function getShopStatistics() {
        $shops = Shop::all();
        return new ShopStatisticsResource($shops);
    }

    public function getCustomerStatistics() {
        $users = User::all();
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
