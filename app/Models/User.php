<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Carbon\Carbon;

class Card {
    readonly string $number;
    readonly int $shoppingCenterId;
    readonly string $status;
    readonly mixed $nextStatus;
    readonly int $toNextStatus;
    readonly int $bonusesAmount;

    public function __construct(string $number,
                                int $shoppingCenterId, 
                                string $status, 
                                mixed $nextStatus,
                                int $toNextStatus,
                                int $bonusesAmount) {
        $this->number = $number;
        $this->shoppingCenterId = $shoppingCenterId;
        $this->status = $status;
        $this->nextStatus = $nextStatus;
        $this->toNextStatus = $toNextStatus;
        $this->bonusesAmount = $bonusesAmount;
    }
}

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
        'phone',
        'birth_date',
        'role_id',
        'email',
        'card_number',
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

    /**
     * магазин, в котором работает пользователь с ролью seller(продавец)
     */ 
    public function jobShop()
    {
        $bundle = SellerShopBundle::where('seller_id', $this->id)->first();
        return Shop::find($bundle->shop_id);
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

    public function account($shoppingCenterId = 1) {
        $cardAccount = CardAccount::where('user_id', $this->id);
        if ($shoppingCenterId) {
            $cardAccount->where('shopping_center_id', $shoppingCenterId);
        }
        return $cardAccount->first();
    }

    public function card($shoppingCenterId = 1) {
        $cardAccount = $this->account($shoppingCenterId);
        $nextStatus = null;
        if ($cardAccount->nextStatus()) {
            $nextStatus = $cardAccount->nextStatus()->name;
        }
        $card = new Card($this->card_number,
                         $cardAccount->shopping_center_id,
                         $cardAccount->status()->name,
                         $nextStatus,
                         $cardAccount->toNextStatus(),
                         $cardAccount->bonuses_amount);
        return $card;
    }

    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }
}
