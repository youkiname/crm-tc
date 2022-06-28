<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitorAmountResource extends JsonResource
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return [
            'date' => $this->date,
            'amount' => $this->amount,
        ];
    }
}
