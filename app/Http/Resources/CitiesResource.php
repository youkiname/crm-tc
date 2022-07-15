<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CitiesResource extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return CityResource::collection($this->collection);
    }
}
