<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Abstract\StatisticController;
use Illuminate\Http\Request;

use Carbon\Carbon;

class RenterStatisticController extends StatisticController
{
    public function getCustomerStatistics(Request $request) {
        $shop = $request->user()->shop;
        return parent::_getCustomerStatistics(null, $shop->id);
    }

    public function getSellerStatistics(Request $request) {
        $shop = $request->user()->shop;
        return parent::_getSellerStatistics($shop->id);
    }

    public function getVisitorsAmountToday(Request $request) {
        $shop = $request->user()->shop;
        $request->merge([
            'shopping_center_id' => $shop->shoppingCenter->id,
        ]);
        return parent::getVisitorsAmountToday($request);
    }

    public function getVisitorsAmountMonth(Request $request) {
        $shop = $request->user()->shop;
        $request->merge([
            'shopping_center_id' => $shop->shoppingCenter->id,
        ]);
        return parent::getVisitorsAmountMonth($request);
    }

    public function getVisitorsGraph(Request $request) {
        $shop = $request->user()->shop;
        $shoppingCenterId = $shop->shoppingCenter->id;
        return $this->getVisitorsGraphData($request->start_date, $request->end_date, $shoppingCenterId);
    }

    public function getVisitorsGraphMonth(Request $request) {
        $shop = $request->user()->shop;
        $shoppingCenterId = $shop->shoppingCenter->id;
        return $this->getVisitorsGraphData(Carbon::now()->subDays(30), null, $shoppingCenterId);
    }

    public function getVisitorsAgePlot(Request $request) {
        $shop = $request->user()->shop;
        $shoppingCenterId = $shop->shoppingCenter->id;
        return $this->getVisitorsAgePlotData(null, $shoppingCenterId);
    }

    public function getVisitorsAgePlotWeek(Request $request) {
        $shop = $request->user()->shop;
        $shoppingCenterId = $shop->shoppingCenter->id;
        return $this->getVisitorsAgePlotData(Carbon::now()->subDays(7), $shoppingCenterId);
    }

    public function getVisitorsAgePlotMonth(Request $request) {
        $shop = $request->user()->shop;
        $shoppingCenterId = $shop->shoppingCenter->id;
        return $this->getVisitorsAgePlotData(Carbon::now()->subDays(30), $shoppingCenterId);
    }

    public function getVisitorsAgePlotYear(Request $request) {
        $shop = $request->user()->shop;
        $shoppingCenterId = $shop->shoppingCenter->id;
        return $this->getVisitorsAgePlotData(Carbon::now()->subDays(365), $shoppingCenterId);
    }
}
