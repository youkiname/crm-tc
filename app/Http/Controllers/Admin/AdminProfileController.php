<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Abstract\ProfileController;
use Illuminate\Http\Request;

class AdminProfileController extends ProfileController
{
    public function update(Request $request) {
        parent::update($request);
        $admin = $request->user();

        $shoppingCenter = $admin->shoppingCenter();
        $shoppingCenter->name = $request->shopping_center_name ?? $shoppingCenter->name;
        $shoppingCenter->description = $request->description ?? $shoppingCenter->description;
        $shoppingCenter->address = $request->address ?? $shoppingCenter->address;
        $shoppingCenter->city_id = $request->city_id ?? $shoppingCenter->city_id;
        $shoppingCenter->save();
        return new UserResource($admin);
    }
}
