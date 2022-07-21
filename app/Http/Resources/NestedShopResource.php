<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NestedShopResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cashback' => $this->cashback,
            'category' => new ShopCategoryResource($this->category),
            'legal_form' => $this->legal_form
        ];
    }
}
