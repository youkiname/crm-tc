<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

use App\Models\Transaction;

class SellerStatisticResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->fullName(),
            'transactions_per_week' => $this->getTransactionsAmount(Carbon::now()->subDays(7)),
            'transactions_per_month' => $this->getTransactionsAmount(Carbon::now()->subDays(30)),
            'transactions_per_year' => $this->getTransactionsAmount(Carbon::now()->subYear()),
            'income_per_week' => $this->getIncomeAmount(Carbon::now()->subDays(7)),
            'income_per_month' => $this->getIncomeAmount(Carbon::now()->subDays(30)),
            'income_per_year' => $this->getIncomeAmount(Carbon::now()->subYear()),
        ];
    }

    private function getTransactionsAmount($fromDate) {
        return Transaction::where('created_at', '>=', $fromDate)
        ->where('shop_id', $this->jobShop()->id)
        ->where('seller_id', $this->id)
        ->count();
    }

    private function getIncomeAmount($fromDate) {
        $amount = Transaction::where('created_at', '>=', $fromDate)
        ->where('shop_id', $this->jobShop()->id)
        ->where('seller_id', $this->id)
        ->sum('amount');
        return intval($amount);
    }
}
