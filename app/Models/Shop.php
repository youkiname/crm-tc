<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(ShopCategory::class, 'category_id', 'id');
    }

    public function shoppingCenter()
    {
        return $this->belongsTo(ShoppingCenter::class, 'shopping_center_id', 'id');
    }
}
