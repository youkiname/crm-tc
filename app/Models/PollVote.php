<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'poll_id',
        'choice_id',
        'user_id',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id', 'id');
    }
    
    public function choice()
    {
        return $this->belongsTo(PollChoice::class, 'choice_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
