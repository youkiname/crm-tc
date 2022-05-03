<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'type' => $this->messageType->name,
            'sender' => new NestedUserResource($this->sender),
            'receiver' => new NestedUserResource($this->receiver),
        ];
    }
}
