<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Abstract\SellerController;
use Illuminate\Http\Request;

class RenterSellerController extends SellerController
{
    public function index(Request $request) {
        $request->merge([
            'shop_id' => $request->user()->shop->id,
        ]);
        return parent::index($request);
    }
}
