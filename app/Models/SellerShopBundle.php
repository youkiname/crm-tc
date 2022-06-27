<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerShopBundle extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id',
        'shop_id',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'user_id', 'id');
    }
}
