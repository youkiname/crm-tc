<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MessagesResource extends ResourceCollection
{
    public static $wrap = null;
    public function toArray($request)
    {
        return MessageResource::collection($this->collection);
    }
}
