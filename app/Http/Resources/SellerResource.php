<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return [
        'id' => $this->id,
        'first_name' => $this->first_name,
        'last_name' => $this->last_name,
        'full_name' => $this->fullName(),
        'email' => $this->email,
        'phone' => $this->phone,
        'cashback' => $this->cashback,
        'age' => $this->age(),
        'is_email_verified' => $this->isEmailVerified(),
        ];
    }
}
