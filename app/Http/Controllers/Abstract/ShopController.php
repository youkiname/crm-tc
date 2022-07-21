<?php

namespace App\Http\Controllers\Abstract;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\CreateShopRequest;

use App\Http\Resources\ShopResource;
use App\Http\Resources\ShopsResource;
use App\Http\Resources\ShopCategoriesResource;

use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\User;
use App\Models\Role;

class ShopController extends Controller
{
    public function index()
    {
        $collection = Shop::all();
        return new ShopsResource($collection);
    }

    public function store(CreateShopRequest $request)
    {
        $renter = User::create([
            'first_name' => $request->renter_name,
            'phone' => $request->renter_phone,
            'email' => $request->renter_email,
            'password' => Hash::make($request->renter_password),
            'role_id' => Role::where('name', 'renter')->first()->id,
            'card_number' => $this->generateCardNumber(),
        ]);
        
        $shop = Shop::create([
            'name' => $request->name,
            'renter_id' => $renter->id,
            'avatar_link' => $this->saveAvatar($request),
            'cashback' => $request->cashback ?? 0,
            'shopping_center_id' => $request->user()->shoppingCenter()->id,
            'category_id' => $request->category_id,
        ]);

        return new ShopResource($shop);
    }

    public function show(Shop $shop)
    {
        return new ShopResource($shop);
    }

    public function update(Request $request, $id)
    {
        $shop = Shop::find($id);
        $shop->name = $request->name ?? $shop->name;
        $shop->category_id = $request->category_id ?? $shop->category_id;
        if ($request->file('avatar')) {
            $shop->avatar_link = $this->saveAvatar($request);
        }
        $shop->save();
        $renter = $shop->renter;
        $this->updateRenter($renter, $request);
        return new ShopResource($shop);
    }

    public function destroy($id)
    {
        Shop::where('id', $id)->delete();
        return $this->jsonSuccess();
    }

    public function getCategories()
    {
        $categories = ShopCategory::all();
        return new ShopCategoriesResource($categories);
    }

    private function saveAvatar($request) {
        if ($request->file('avatar')) {
            return $this->storeImage($request->file('avatar'), 'static/shop_avatars');
        }
        return null;
    }

    private function updateRenter($renter, $request) {
        $renter->first_name = $request->renter_name ?? $renter->first_name;
        $renter->phone = $renter->renter_phone ?? $renter->phone;
        $renter->email = $renter->renter_email ?? $renter->email;
    }
}
