<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateShopRequest;

use App\Http\Resources\ShopResource;
use App\Http\Resources\ShopsResource;

use App\Models\Shop;

class ShopController extends Controller
{
    public function index()
    {
        $collection = Shop::all();
        return new ShopsResource($collection);
    }

    public function create()
    {
        //
    }

    public function store(CreateShopRequest $request)
    {
        $shop = Shop::create([
            'name' => $request->name,
            'cashback' => $request->cashback,
            'shopping_center_id' => $request->shopping_center_id,
            'category_id' => $request->category_id,
        ]);

        return new ShopResource($shop);
    }

    public function show(Shop $shop)
    {
        return new ShopResource($shop);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Shop::where('id', $id)->delete();
        return response()->json([
            'success' => true,
        ]);
    }
}
