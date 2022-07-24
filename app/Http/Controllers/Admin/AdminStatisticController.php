<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Abstract\StatisticController;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminStatisticController extends StatisticController
{
    public function getCustomerStatistics(Request $request) {
        $shoppingCenter = $request->user()->shoppingCenter();
        return $this->_getCustomerStatistics($shoppingCenter->id);
    }

    public function getShopStatistics(Request $request) {
        $shoppingCenter = $request->user()->shoppingCenter();
        return $this->_getShopStatistics($shoppingCenter->id);
    }

    public function getVisitorsGraph(Request $request){
        $shoppingCenter = $request->user()->shoppingCenter();
        return $this->_getVisitorsGraphData($request->start_date, 
        $request->end_date,
        $shoppingCenter->id);
    }

    public function getVisitorsGraphMonth(Request $request){
        $shoppingCenter = $request->user()->shoppingCenter();
        return $this->_getVisitorsGraphData(Carbon::now()->subDays(30), 
        null,
        $shoppingCenter->id);
    }

    public function getVisitorsAgePlotWeek(Request $request) {
        $shoppingCenter = $request->user()->shoppingCenter();
        return $this->_getVisitorsAgePlotData(Carbon::now()->subDays(7), $shoppingCenter->id);
    }
}
