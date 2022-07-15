<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SellersResource extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return SellerResource::collection($this->collection);
    }
}
