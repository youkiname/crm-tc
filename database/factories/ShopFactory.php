<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\ShopCategory;
use App\Models\ShoppingCenter;
use App\Models\User;
use App\Models\Role;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    public function definition()
    {
        $renterRoleId = Role::where('name', 'renter')->first()->id;
        return [
            "name" => $this->faker->company(),
            "renter_id" => User::where('role_id', $renterRoleId)->inRandomOrder()->first()->id,
            "cashback" => $this->faker->numberBetween($min = 5, $max = 20),
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
            'category_id' => ShopCategory::inRandomOrder()->first()->id,
        ];
    }
}
