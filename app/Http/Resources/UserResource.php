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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'mobile' => $this->mobile,
            'card' => new CardResource($this->card),
            'cashback' => $this->cashback,
            'role' => [
                'id' => $this->role->id,
                'name' => $this->role->name,
            ],
            'age' => $this->age(),
            'is_email_verified' => $this->isEmailVerified(),
            'avatar_link' => 'https://picsum.photos/500/500',
        ];
    }
}
