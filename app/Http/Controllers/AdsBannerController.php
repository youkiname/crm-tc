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
        $collection = AdsBanner::orderBy('created_at');
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
            'comment' => $request->comment ?? ''
        ]);
        return new AdsBannerResource($banner);
    }

    public function show($id)
    {
        return new AdsBannerResource(AdsBanner::find($id));
    }

    public function update(Request $request, $id)
    {
        $banner = AdsBanner::find($id);
        $banner->name = $request->name ?? $banner->name;
        $banner->start_date = $request->start_date ?? $banner->start_date;
        $banner->end_date = $request->end_date ?? $banner->end_date;
        $banner->gender = $request->gender ?? $banner->gender;
        $banner->min_age = $request->min_age ?? $banner->min_age;
        $banner->max_age = $request->max_age ?? $banner->max_age;
        $banner->min_balance = $request->min_balance ?? $banner->min_balance;
        $banner->max_balance = $request->max_balance ?? $banner->max_balance;
        $banner->comment = $request->comment ?? $banner->comment;
        $banner->is_active = $request->is_active ?? $banner->is_active;

        if ($request->file('image')) {
            $imageLink = $this->storeImage($request->file('image'), 'static/banners');
            $banner->image_link = $imageLink;
        }
        $banner->save();

        return new AdsBannerResource($banner);
    }

    public function destroy($id)
    {
        AdsBanner::where('id', $id)->delete();
        return $this->jsonSuccess();
    }

    public function activateBanner($id)
    {
        AdsBanner::where('id', $id)->update(['is_active' => 1]);
        return response()->json([
            'success' => true,
        ]);
    }

    public function deactivateBanner($id)
    {
        AdsBanner::where('id', $id)->update(['is_active' => 0]);
        return response()->json([
            'success' => true,
        ]);
    }
}
