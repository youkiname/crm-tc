<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'shop_id',
        'image_link',
        'start_date',
        'end_date',
        'is_active',
        'gender',
        'min_age',
        'max_age',
        'min_balance',
        'max_balance',
    ];
}
