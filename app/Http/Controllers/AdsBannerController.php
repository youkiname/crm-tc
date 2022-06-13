<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateAdsBannerRequest;

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

    public function create(Request $request)
    {
        
    }

    public function store(CreateAdsBannerRequest $request)
    {
        $banner = AdsBanner::create([
            'link' => $request->link,
            'image_link' => $this->storeImage($request)
        ]);
        return new AdsBannerResource($banner);
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
        AdsBanner::where('id', $id)->delete();
        return response()->json([
            'success' => true,
        ]);
    }

    private function storeImage($request) {
        $file = $request->file('image');
        $filename = date('YmdHi').$file->getClientOriginalName();
        $file->move(public_path('static/banners'), $filename);
        return '/static/banners/' . $filename;
    }
}
