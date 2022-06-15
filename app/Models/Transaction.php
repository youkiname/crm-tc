<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'customer_id',
        'shop_id',
        "shopping_center_id",
        "bonuses_offset",
        "amount",
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function shoppingCenter()
    {
        return $this->belongsTo(ShoppingCenter::class, 'shopping_center_id', 'id');
    }
}
