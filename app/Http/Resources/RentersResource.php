<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RentersResource extends ResourceCollection
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return RenterResource::collection($this->collection);
    }
}
