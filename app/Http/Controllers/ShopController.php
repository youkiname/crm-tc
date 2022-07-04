<?php

namespace App\Http\Controllers;

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
            'shopping_center_id' => $request->shopping_center_id,
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
        //
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
}
