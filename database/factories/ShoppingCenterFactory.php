<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ShoppingCenterFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->text($maxNbChars = 100) ,
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'coordinates' => $this->faker->latitude($min = -90, $max = 90) . ';' . $this->faker->longitude($min = -90, $max = 90),
        ];
    }
}
