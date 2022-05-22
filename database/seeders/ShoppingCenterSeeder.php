<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ShoppingCenter;

class ShoppingCenterSeeder extends Seeder
{
    public function run()
    {
        ShoppingCenter::factory()->count(10)->create();
    }
}
