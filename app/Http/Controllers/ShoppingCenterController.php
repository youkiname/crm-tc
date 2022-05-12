<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\ShoppingCenterResource;
use App\Http\Resources\ShoppingCentersResource;

use App\Models\ShoppingCenter;

class ShoppingCenterController extends Controller
{

    public function index()
    {
        $collection = ShoppingCenter::paginate(15);
        return new ShoppingCentersResource($collection);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
        //
    }
}
