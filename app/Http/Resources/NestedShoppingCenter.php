<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NestedShoppingCenter extends JsonResource
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'avatar_link' => 'https://picsum.photos/500/500',
        ];
    }
}
