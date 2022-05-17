<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Poll;

class PollChoiceFactory extends Factory
{
    public function definition()
    {
        return [
            'poll_id' => Poll::inRandomOrder()->first()->id,
            'title' => $this->faker->word(),
        ];
    }
}
