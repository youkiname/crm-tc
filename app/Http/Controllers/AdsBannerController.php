<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\AdsBannerResource;
use App\Http\Resources\AdsBannersResource;

use App\Models\AdsBanner;

class AdsBannerController extends Controller
{
    public function index(Request $request)
    {
        $limit = 2;
        if($request->limit) {
            $limit = $request->limit;
        }
        $collection = AdsBanner::inRandomOrder()->limit($limit)->get();
        return new AdsBannersResource($collection);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return new AdsBannerResource(AdsBanner::find($id));
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
