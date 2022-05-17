<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\ShoppingCenter;

class PollFactory extends Factory
{

    public function definition()
    {
        return [
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
            'title' => $this->faker->words($nb = 4, $asText = true),
            'description' => $this->faker->text($maxNbChars = 50),
            'created_at' => $this->faker->dateTimeThisYear($max = 'now', $timezone = "UTC"),
        ];
    }
}
