<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\City;

class ShoppingCenterFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->text($maxNbChars = 100) ,
            'address' => $this->faker->address(),
            'city_id' => City::inRandomOrder()->first()->id,
            'coordinates' => $this->faker->latitude($min = -90, $max = 90) . ';' . $this->faker->longitude($min = -90, $max = 90),
        ];
    }
}
