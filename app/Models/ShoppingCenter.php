<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'avatar_link',
        'city_id',
        'coordinates',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

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
