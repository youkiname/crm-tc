<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Role;
use App\Models\Shop;
use App\Models\ShoppingCenter;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $sellerRoleId = Role::where('name', 'seller')->first()->id;
        $customerRoleId = Role::where('name', 'customer')->first()->id;
        $seller = User::where('role_id', $sellerRoleId)->inRandomOrder()->first();
        $customer = User::where('role_id', $customerRoleId)->inRandomOrder()->first();
        $shop = $seller->jobShop();
        return [
            'seller_id' => $seller->id,
            'customer_id' => $customer->id,
            'shopping_center_id' => $shop->shoppingCenter->id,
            'shop_id' => $shop->id,
            "bonuses_offset" => $this->faker->numberBetween($min = -200, $max = 200),
            "amount" => $this->faker->numberBetween($min = 5, $max = 400),
            'created_at' => $this->faker->dateTimeThisMonth($max = 'now', $timezone = "UTC")
        ];
    }
}
