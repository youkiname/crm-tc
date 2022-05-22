<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Shop;

class ShopSeeder extends Seeder
{
    public function run()
    {
        Shop::factory()->count(50)->create();
    }
}
