<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VisitorAmountListResource extends ResourceCollection
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return VisitorAmountResource::collection($this->collection);
    }
}
