<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return [
            'number' => $this->number,
            'status' => $this->status->name,
            'bonuses_amount' => $this->bonuses_amount,
        ];
    }
}
