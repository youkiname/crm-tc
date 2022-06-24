<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userData = [
            'role_id' => Role::inRandomOrder()->first()->id,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->randomElement($array = array ('male', 'female')),
            'phone' => $this->faker->phoneNumber(),
            'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '123123123',
            'remember_token' => Str::random(10),
        ];
        if ($userData['role_id'] == 2) {
            $userData['cashback'] = $this->faker->numberBetween($min = 5, $max = 30);
        }
        return $userData;
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
