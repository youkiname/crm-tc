<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminShoppingCenterBundle extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'shopping_center_id',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }

    public function shoppingCenter()
    {
        return $this->belongsTo(ShoppingCenter::class, 'shopping_center_id', 'id');
    }
}
