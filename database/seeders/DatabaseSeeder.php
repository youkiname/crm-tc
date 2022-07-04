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
        Role::create([
            'name' => 'renter'
        ]);
        Role::create([
            'name' => 'admin'
        ]);

        CardStatus::create([
            'name' => 'Bronze',
            'cashback' => 10,
            'threshold' => 0,
        ]);
        CardStatus::create([
            'name' => 'Silver',
            'cashback' => 15,
            'threshold' => 100,
        ]);
        CardStatus::create([
            'name' => 'Gold',
            'cashback' => 20,
            'threshold' => 1000,
        ]);
        CardStatus::create([
            'name' => 'Platinum',
            'cashback' => 25,
            'threshold' => 3000,
        ]);
        CardStatus::create([
            'name' => 'VIP',
            'cashback' => 30,
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
            UserSeeder::class,
            ShoppingCenterSeeder::class,
            CardAccountSeeder::class,
            ShopSeeder::class,
            SellerShopBundleSeeder::class,
            AdminShoppingCenterBundleSeeder::class,
            TransactionSeeder::class,
            PollSeeder::class,
            AdsBannerSeeder::class,
            VisitorSeeder::class,
        ]);
    }
}
