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
            'cashback' => $this->cashback,
            'role' => [
                'id' => $this->role->id,
                'name' => $this->role->name,
            ],
            'age' => $this->age(),
            'avatar_link' => 'https://picsum.photos/500/500',
        ];
    }
}
