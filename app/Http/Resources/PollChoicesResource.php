<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PollChoicesResource extends ResourceCollection
{

    public function toArray($request)
    {
        return PollChoiceResource::collection($this->collection);
    }
}
