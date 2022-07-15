<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SellerStatisticsResource extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return SellerStatisticResource::collection($this->collection);
    }
}
