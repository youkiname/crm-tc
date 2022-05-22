<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'mobile',
        'birth_date',
        'role_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isEmailVerified() {
        return (bool) $this->email_verified_at;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function age()
    {
        $age = Carbon::parse($this->birth_date)->diff(Carbon::now())->y;
        return $age;
    }

    public function isSeller()
    {
        return $this->role_id == 2;
    }

    public function card($shoppingCenterId = 1) {
        $card = Card::where('user_id', $this->id);
        if ($shoppingCenterId) {
            $card->where('shopping_center_id', $shoppingCenterId);
        }
        return $card->first();
    }

    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }
}
