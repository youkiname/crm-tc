<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PollsResource extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return PollResource::collection($this->collection);
    }
}
