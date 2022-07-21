<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'renter_id',
        'avatar_link',
        'cashback',
        'shopping_center_id',
        'category_id',
        'legal_form',
    ];

    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ShopCategory::class, 'category_id', 'id');
    }

    public function shoppingCenter()
    {
        return $this->belongsTo(ShoppingCenter::class, 'shopping_center_id', 'id');
    }
}
