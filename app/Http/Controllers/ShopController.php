<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateShopRequest;

use App\Http\Resources\ShopResource;
use App\Http\Resources\ShopsResource;

use App\Models\Shop;
use App\Models\Renter;

class ShopController extends Controller
{
    public function index()
    {
        $collection = Shop::all();
        return new ShopsResource($collection);
    }

    public function store(CreateShopRequest $request)
    {
        $renter = Renter::create([
            'name' => $request->renter_name,
            'phone' => $request->renter_phone,
            'email' => $request->renter_email,
            'password' => $request->renter_password,
        ]);
        
        $shop = Shop::create([
            'name' => $request->name,
            'renter_id' => $renter->id,
            'avatar_link' => $this->getAvatarLink($request),
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

    private function getAvatarLink($request) {
        if ($request->file('avatar')) {
            return $this->storeImage($request->file('avatar'), 'static/shop_avatars');
        }
        return null;
    }
}
