<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Shop;
use App\Models\Renter;

class ShopSeeder extends Seeder
{
    public function run()
    {
        Renter::factory()->count(50)->create();
        Shop::factory()->count(50)->create();
    }
}
