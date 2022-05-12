<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'threshold',
        "number",
        "bonuses_amount",
    ];

    public function status()
    {
        $status = CardStatus::where('threshold', '<=', $this->bonuses_amount)
        ->orderBy('threshold', 'desc')->first();
        return $status;
    }

    public function nextStatus() {
        $status = CardStatus::where('threshold', '>', $this->bonuses_amount)
        ->orderBy('threshold', 'asc')->first();
        return $status;
    }
}
