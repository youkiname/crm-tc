<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\AdsBanner;

class AdsBannerSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 6; $i++) {
            AdsBanner::create([
                'image_link' => '/static/banners/' . $i . '.jpg',
                'link' => 'google.com',
            ]);
        }
    }
}
