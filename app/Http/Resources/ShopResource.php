<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        $avatarLink = 'https://picsum.photos/500/500';
        if ($this->avatar_link) {
            $avatarLink = 'https://api.top-sistem.ru' . $this->avatar_link;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cashback' => $this->cashback,
            'category' => new ShopCategoryResource($this->category),
            'avatar_link' => $avatarLink,
            'renter' => new RenterResource($this->renter)
        ];
    }
}
