<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\CardStatus;
use App\Models\ShopCategory;
use App\Models\MessageType;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'name' => 'customer'
        ]);
        Role::create([
            'name' => 'seller'
        ]);

        CardStatus::create([
            'name' => 'Bronze',
            'threshold' => 0,
        ]);
        CardStatus::create([
            'name' => 'Silver',
            'threshold' => 100,
        ]);
        CardStatus::create([
            'name' => 'Gold',
            'threshold' => 1000,
        ]);
        CardStatus::create([
            'name' => 'Platinum',
            'threshold' => 3000,
        ]);
        CardStatus::create([
            'name' => 'VIP',
            'threshold' => 5000,
        ]);

        ShopCategory::create([
            'name' => 'Косметика'
        ]);
        ShopCategory::create([
            'name' => 'Развлечения'
        ]);
        ShopCategory::create([
            'name' => 'Продукты питания'
        ]);
        ShopCategory::create([
            'name' => 'Одежда'
        ]);
        ShopCategory::create([
            'name' => 'Электроника'
        ]);

        MessageType::create([
            'name' => 'text',
        ]);
        MessageType::create([
            'name' => 'image',
        ]);
        MessageType::create([
            'name' => 'video',
        ]);
        
        $this->call([
            // UserSeeder::class,
            ShoppingCenterSeeder::class,
            CardSeeder::class,
            ShopSeeder::class,
            TransactionSeeder::class,
            PollSeeder::class,
            AdsBannerSeeder::class,
        ]);
    }
}
