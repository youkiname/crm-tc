<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ShopsResource extends ResourceCollection
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return ShopResource::collection($this->collection);
    }
}
