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
        $collection = AdsBanner::where('is_active', true);
        $collection = $this->tryAddPaginationAndLimit($collection, $request);
        return new AdsBannersResource($collection);
    }

    public function store(CreateAdsBannerRequest $request)
    {
        $banner = AdsBanner::create([
            'name' => $request->name,
            'shop_id' => $request->shop_id,
            'image_link' => $this->storeImage($request->file('image'), 'static/banners'),
            'start_date' => $request->start_date ?? date("Y-m-d"),
            'end_date' => $request->end_date,
            'min_age' => $request->min_age ?? 0,
            'max_age' => $request->min_age ?? 1000,
            'min_balance' => $request->min_balance ?? 0,
            'max_balance' => $request->max_balance ?? 2147483647,
        ]);
        return new AdsBannerResource($banner);
    }

    public function show($id)
    {
        return new AdsBannerResource(AdsBanner::find($id));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        AdsBanner::where('id', $id)->delete();
        return $this->jsonSuccess();
    }
}
