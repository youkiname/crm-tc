<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shopping_center_id',
        "bonuses_amount",
    ];

    public function shoppingCenter()
    {
        return $this->belongsTo(ShoppingCenter::class, 'shopping_center_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        $status = CardStatus::where('threshold', '<=', $this->bonuses_amount)
        ->orderBy('threshold', 'desc')->first();
        return $status;
    }

    public function nextStatus() {
        $status = CardStatus::where('threshold', '>', $this->bonuses_amount)
        ->orderBy('threshold', 'asc')->first();
        return $status;
    }

    public function toNextStatus() {
        if (!$this->nextStatus()) {
            return 0;
        }
        return $this->nextStatus()->threshold - $this->bonuses_amount;
    }
}
