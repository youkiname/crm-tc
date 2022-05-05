<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->fullName(),
            'card' => new CardResource($this->card),
            'role' => [
                'id' => $this->role->id,
                'name' => $this->role->name,
            ]
        ];
    }
}
