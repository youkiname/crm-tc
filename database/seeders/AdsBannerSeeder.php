<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\AdsBanner;
use App\Models\Shop;

class AdsBannerSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 6; $i++) {
            AdsBanner::create([
                'name' => 'Banner ' . $i,
                'shop_id' => Shop::inRandomOrder()->first()->id,
                'image_link' => '/static/banners/' . $i . '.jpg',
                'start_date' => date('Y-m-d'),
                'min_age' => 10,
                'max_age' => 99,
                'min_balance' => 0,
                'max_balance' => 9999,
                'comment' => ''
            ]);
        }
    }
}
