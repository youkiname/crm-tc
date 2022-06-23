<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
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
        return [
            'seller_id' => User::inRandomOrder()->first()->id,
            'customer_id' => User::inRandomOrder()->first()->id,
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
            'shop_id' => Shop::inRandomOrder()->first()->id,
            "bonuses_offset" => $this->faker->numberBetween($min = -200, $max = 200),
            "amount" => $this->faker->numberBetween($min = 5, $max = 400),
        ];
    }
}
