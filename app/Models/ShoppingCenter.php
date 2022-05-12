<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCenter extends Model
{
    use HasFactory;

    public function shops()
    {
        return $this->hasMany(Shop::class, 'shopping_center_id', 'id');
    }

    public function latitude()
    {
        return explode(';', $this->coordinates)[0];
    }

    public function longitude()
    {
        return explode(';', $this->coordinates)[1];
    }
}
