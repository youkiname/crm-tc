<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\ShopCategory;
use App\Models\ShoppingCenter;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->company(),
            "cashback" => $this->faker->numberBetween($min = 5, $max = 20),
            'category_id' => ShopCategory::inRandomOrder()->first()->id,
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
        ];
    }
}
