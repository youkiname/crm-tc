<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticatedUserResource extends UserResource
{
    private string $token='null';

    public function addToken($token) {
        $this->token = $token;
        return $this;
    }
    
    public function toArray($request)
    {
        $userResource = parent::toArray($request);
        $userResource['token'] = $this->token;
        return $userResource;
    }
}
