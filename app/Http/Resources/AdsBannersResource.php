<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdsBannersResource extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return AdsBannerResource::collection($this->collection);
    }
}
