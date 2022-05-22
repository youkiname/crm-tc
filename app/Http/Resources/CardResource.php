<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return [
            'shopping_center_id' => $this->shopping_center_id,
            'number' => $this->number,
            'status' => $this->status()->name,
            'next_status' => $this->nextStatus()->name ?? NULL,
            'to_next_status' => $this->calculateBonusesToNextStatus(),
            'bonuses_amount' => $this->bonuses_amount,
        ];
    }

    private function calculateBonusesToNextStatus() {
        if (!$this->nextStatus()) {
            return 0;
        }
        return $this->nextStatus()->threshold - $this->bonuses_amount;
    }
}
