<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Transaction;

use Carbon\Carbon;

class ShopStatisticResource extends JsonResource
{
    public static $wrap = null;

public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'renter_name' => $this->renter->fullName(),
            'transactions_per_week' => $this->getTransactionsAmount(Carbon::now()->subDays(7)),
            'transactions_per_month' => $this->getTransactionsAmount(Carbon::now()->subDays(30)),
            'income_per_week' => $this->getIncomeAmount(Carbon::now()->subDays(7)),
            'income_per_month' => $this->getIncomeAmount(Carbon::now()->subDays(30)),
        ];
    }

    private function getTransactionsAmount($fromDate) {
        return Transaction::where('created_at', '>=', $fromDate)
        ->where('shop_id', $this->id)
        ->count();
    }

    private function getIncomeAmount($fromDate) {
        return Transaction::where('created_at', '>=', $fromDate)
        ->where('shop_id', $this->id)
        ->sum('amount');
    }
}
