<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\User;
use App\Models\ShoppingCenter;
use App\Models\Shop;
use App\Models\Card;
use App\Models\Transaction;
use App\Models\Message;

use App\Models\CardStatus;
use App\Models\ShopCategory;
use App\Models\MessageType;
use App\Models\AdsBanner;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
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
        

        User::factory()->count(10)->create();
        Card::factory()->count(10)->create();
        ShoppingCenter::factory()->count(10)->create();
        Shop::factory()->count(50)->create();
        Transaction::factory()->count(100)->create();

        for ($i = 1; $i <= 6; $i++) {
            AdsBanner::create([
                'image_link' => '/static/banners/' . $i . '.jpg',
                'link' => 'google.com',
            ]);
        }
    }
}
