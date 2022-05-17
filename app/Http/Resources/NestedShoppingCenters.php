<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NestedShoppingCenters extends ResourceCollection
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return NestedShoppingCenter::collection($this->collection);
    }
}
