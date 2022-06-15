<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CardStatusesResource extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return CardStatusResource::collection($this->collection);
    }
}
