<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'shopping_center_id',
        'title',
        'description',
        'created_at'
    ];

    public function choices()
    {
        return $this->hasMany(PollChoice::class, 'poll_id', 'id');
    }

    public function shoppingCenter()
    {
        return $this->belongsTo(ShoppingCenter::class, 'shopping_center_id', 'id');
    }
}
