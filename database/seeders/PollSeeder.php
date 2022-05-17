<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Poll;
use App\Models\PollChoice;

class PollSeeder extends Seeder
{
    public function run()
    {
        Poll::factory()->count(40)->create();
        for ($poll_id = 1; $poll_id < Poll::count(); $poll_id++) {
            PollChoice::factory()->count(random_int(2, 5))->state([
                'poll_id' => $poll_id,
            ])->create();
        }
    }
}
