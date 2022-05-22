<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\ShoppingCenter;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
            "number" => $this->faker->creditCardNumber(),
            "bonuses_amount" => $this->faker->numberBetween($min = 50, $max = 6000),
        ];
    }
}
