<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GraphListResource extends ResourceCollection
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return GraphItemResource::collection($this->collection);
    }
}
