<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'seller' => new NestedUserResource($this->seller),
            'customer' => new NestedUserResource($this->customer),
            'shop' => [
                'id' => $this->shop->id,
                'name' => $this->shop->name,
                'category' => $this->shop->category->name,
            ],
            'shopping_center' => new NestedShoppingCenter($this->shoppingCenter),
            'bonuses_offset' => $this->bonuses_offset,
            'amount' => $this->amount,
            'created_at' => $this->created_at
        ];
    }
}
