<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return [
            'shopping_center_id' => $this->shoppingCenterId,
            'number' => $this->number,
            'status' => $this->status,
            'next_status' => $this->nextStatus ?? NULL,
            'to_next_status' => $this->toNextStatus,
            'bonuses_amount' => $this->bonusesAmount,
        ];
    }
}
