<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerStatisticsResource extends ResourceCollection
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return CustomerStatisticResource::collection($this->collection);
    }
}
