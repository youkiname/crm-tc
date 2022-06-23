<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cashback' => $this->cashback,
            'category' => new ShopCategoryResource($this->category),
            'avatar_link' => $this->avatar_link ?? 'https://picsum.photos/500/500',
            'renter' => new RenterResource($this->renter)
        ];
    }
}
