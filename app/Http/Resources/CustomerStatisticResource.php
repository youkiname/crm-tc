<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Transaction;

class CustomerStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        $transactions = Transaction::where('customer_id', $this->id);
        return [
            'card_number' => $this->card()->number,
            'name' => $this->fullName(),
            'birth_date' => $this->birth_date,
            'purchases_amount' => $transactions->count(),
            'purchases_sum' => $transactions->sum('amount'),
        ];
    }
}
