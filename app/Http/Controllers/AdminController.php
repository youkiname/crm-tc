<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateAdminProfileRequest;

use App\Http\Resources\UserResource;
use App\Http\Resources\ShoppingCenterResource;

use App\Models\User;
use App\Models\ShoppingCenter;

class AdminController extends Controller
{
    public function updateProfile(UpdateAdminProfileRequest $request) {
        $admin = $request->user();
        $admin->first_name = $request->first_name ?? $admin->first_name;
        $admin->last_name = $request->last_name ?? $admin->last_name;
        $admin->phone = $request->phone ?? $admin->phone;
        $admin->save();

        $shoppingCenter = $admin->shoppingCenter();
        $shoppingCenter->name = $request->shopping_center_name ?? $shoppingCenter->name;
        $shoppingCenter->description = $request->description ?? $shoppingCenter->description;
        $shoppingCenter->address = $request->address ?? $shoppingCenter->address;
        $shoppingCenter->city_id = $request->city_id ?? $shoppingCenter->city_id;
        $shoppingCenter->save();
        return new UserResource($admin);
    }
}
