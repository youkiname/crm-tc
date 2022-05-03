<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'seller' => new NestedUserResource($this->seller),
            'customer' => new NestedUserResource($this->customer),
            'shop' => [
                'name' => $this->shop->name,
                'category' => $this->shop->category->name,
            ],  
            'amount' => $this->amount,  
        ];
    }
}
