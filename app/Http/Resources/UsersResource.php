<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UsersResource extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return UserResource::collection($this->collection);
    }
}
