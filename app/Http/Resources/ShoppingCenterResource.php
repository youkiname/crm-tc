<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingCenterResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'city' => $this->city,
            'coordinates' => [
                'lat' => $this->latitude(),
                'long' => $this->longitude(),
            ],
            'avatar_link' => 'https://picsum.photos/500/500',
            'shops' => new ShopsResource($this->shops)
        ];
    }
}
