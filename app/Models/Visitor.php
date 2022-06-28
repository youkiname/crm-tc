<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d';

    protected $fillable = [
        'user_id',
        'shopping_center_id',
    ];
}
