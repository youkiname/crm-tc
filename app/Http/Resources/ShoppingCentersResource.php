<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ShoppingCentersResource extends ResourceCollection
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return ShoppingCenterResource::collection($this->collection);
    }
}
