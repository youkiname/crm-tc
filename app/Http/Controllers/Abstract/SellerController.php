<?php

namespace App\Http\Controllers\Abstract;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UpdateProfileRequest;

use App\Http\Resources\SellerResource;
use App\Http\Resources\SellersResource;

use App\Models\User;
use App\Models\Role;
use App\Models\SellerShopBundle;

class SellerController extends Controller
{

    public function __construct() {
        $this->roleId = Role::where('name', 'seller')->first()->id;
    }

    public function index(Request $request)
    {
        $sellers = User::where('role_id', $this->roleId)
        ->when($request->shop_id, function ($query, $shopId) {
            $query->whereRaw('users.id in 
            (select seller_shop_bundles.seller_id from 
            seller_shop_bundles where 
            seller_shop_bundles.shop_id=?)', [$shopId]);
        })
        ->when($request->shopping_center_id, function ($query, $shoppingCenterId) {
            $query->whereRaw('users.id in 
            (select seller_shop_bundles.seller_id 
            from seller_shop_bundles where 
            seller_shop_bundles.shop_id in 
            (select shops.id from shops where shops.shopping_center_id=?)
            )', [$shoppingCenterId]);
        })
        ->get();
        return new SellersResource($sellers);
    }

    public function store(RegistrationRequest $request)
    {
        $renter = $request->user();
        $shopId = $renter->shop->id;
        $seller = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'card_number' => $this->generateCardNumber(),
            'gender' => $request->gender,
            'phone' => $request->mobile,
            'birth_date' => $request->birth_date,
            'password' => Hash::make($request->password),
            'role_id' => $this->roleId,
        ]);

        SellerShopBundle::create([
            'seller_id' => $seller->id,
            'shop_id' => $shopId
        ]);
        return new SellerResource($seller);
    }

    public function show($id)
    {
        $seller = User::where('role_id', $this->roleId)
        ->where('id', $id)->first();
        return new SellerResource($seller);
    }

    public function update(UpdateProfileRequest $request, $id)
    {
        $seller = User::where('role_id', $this->roleId)->where('id', $id)->first();
        $seller->first_name = $request->first_name ?? $seller->first_name;
        $seller->last_name = $request->last_name ?? $seller->last_name;
        $seller->phone = $request->mobile ?? $seller->phone;
        $seller->birth_date = $request->birth_date ?? $seller->birth_date;
        $seller->email = $request->email ?? $seller->email;
        $seller->email = $request->email ?? $seller->email;
        $seller->gender = $request->gender ?? $seller->gender;
        if ($request->password) {
            $seller->password = Hash::make($request->password);
        }
        $seller->save();
        return new SellerResource($seller);
    }

    public function destroy($id)
    {
        User::where('role_id', $this->roleId)->where('id', $id)->delete();
        return $this->jsonSuccess();
    }
}
