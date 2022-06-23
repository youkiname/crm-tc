<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Card;
use App\Models\User;
use App\Models\ShoppingCenter;

class CardSeeder extends Seeder
{
    public function run()
    { 
        for ($user_id = 1; $user_id <= User::count(); $user_id++) {
            for ($shopping_center_id = 1; $shopping_center_id <= ShoppingCenter::count(); $shopping_center_id++) {
                Card::factory()->state([
                    'user_id' => $user_id,
                    'shopping_center_id' => $shopping_center_id,
                ])->create();
            }
        }
    }
}
