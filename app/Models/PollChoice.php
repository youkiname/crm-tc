<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollChoice extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'poll_id',
        'title',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id', 'id');
    }
}
