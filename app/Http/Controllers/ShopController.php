<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        //
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
        //
    }
}
