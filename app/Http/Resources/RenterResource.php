<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RenterResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'name' => $this->fullName(),
            'phone' => $this->phone,
            'email' => $this->email
        ];
    }
}
