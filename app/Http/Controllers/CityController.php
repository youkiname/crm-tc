<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CityResource;
use App\Http\Resources\CitiesResource;

use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return new CitiesResource($cities);
    }

    public function store(Request $request)
    {
        $city = City::create([
            'name' => $request->name
        ]);
        return new CityResource($city);
    }

    public function show($id)
    {
        return new CityResource(City::find($id));
    }

    public function update(Request $request, $id)
    {
        $city = City::find($id);
        $city->name = $request->name;
        $city->save();
        return new CityResource($city);
    }

    public function destroy($id)
    {
        City::where('id', $id)->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
