<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Abstract\TransactionController;
use Illuminate\Http\Request;

class RenterTransactionController extends TransactionController
{
    public function index(Request $request) {
        $request->merge([
            'shop_id' => $request->user()->shop->id,
        ]);
        return parent::index($request);
    }

    public function getAmountSum(Request $request) {
        $request->merge([
            'shop_id' => $request->user()->shop->id,
        ]);
        return parent::getAmountSum($request);
    }

    public function getAmountSumToday(Request $request) {
        $request->merge([
            'shop_id' => $request->user()->shop->id,
        ]);
        return parent::getAmountSumToday($request);
    }

    public function getAmountSumMonth(Request $request) {
        $request->merge([
            'shop_id' => $request->user()->shop->id,
        ]);
        return parent::getAmountSumMonth($request);
    }

    public function getAverageSumToday(Request $request) {
        $request->merge([
            'shop_id' => $request->user()->shop->id,
        ]);
        return parent::getAverageSumToday($request);
    }

    public function getAverageSumMonth(Request $request) {
        $request->merge([
            'shop_id' => $request->user()->shop->id,
        ]);
        return parent::getAverageSumMonth($request);
    }

    public function getAverageSumGraph(Request $request) {
        $request->merge([
            'shop_id' => $request->user()->shop->id,
        ]);
        return parent::getAverageSumGraph($request);
    }

    public function getSalesRate(Request $request) {
        $request->merge([
            'shop_id' => $request->user()->shop->id,
        ]);
        return parent::getSalesRate($request);
    }
}
