<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    public function status()
    {
        return $this->belongsTo(CardStatus::class, 'status_id', 'id');
    }
}
