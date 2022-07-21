<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Abstract\ProfileController;
use Illuminate\Http\Request;

class RenterProfileController extends ProfileController
{
    public function update(Request $request) {
        parent::update($request);
        $renter = $request->user();

        $shop = $renter->shop;
        $shop->name = $request->shopping_center_name ?? $shop->name;
        $shop->category_id = $request->category_id ?? $shop->category_id;
        $shop->legal_form = $request->legal_form ?? $shop->legal_form;
        $shop->save();
        return new UserResource($admin);
    }
}
