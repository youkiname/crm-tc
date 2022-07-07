<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateShoppingCenterRequest;


use App\Http\Resources\ShoppingCenterResource;
use App\Http\Resources\ShoppingCentersResource;

use App\Models\ShoppingCenter;

class ShoppingCenterController extends Controller
{

    public function index()
    {
        $collection = ShoppingCenter::all();
        return new ShoppingCentersResource($collection);
    }

    public function store(CreateShoppingCenterRequest $request)
    {
        $center = ShoppingCenter::create([
            'name' => $request->name,
            'description' => $request->description ?? '',
            'address' => $request->address,
            'city' => $request->city,
            'coordinates' => $request->lat . ";" > $request->long,
        ]);
        return new ShoppingCenterResource($center);
    }

    public function show(ShoppingCenter $shoppingCenter)
    {
        return new ShoppingCenterResource($shoppingCenter);
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
        ShoppingCenter::where('id', $id)->delete();
        return $this->jsonSuccess();
    }
}
