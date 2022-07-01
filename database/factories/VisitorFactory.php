<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\ShoppingCenter;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitor>
 */
class VisitorFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
            'created_at' => $this->faker->dateTimeThisYear($max = 'now')
        ];
    }
}
