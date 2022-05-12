<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "user_id" => $this->faker->unique()->numberBetween(1, User::count()),
            "number" => $this->faker->creditCardNumber(),
            "bonuses_amount" => $this->faker->numberBetween($min = 50, $max = 6000),
        ];
    }
}
