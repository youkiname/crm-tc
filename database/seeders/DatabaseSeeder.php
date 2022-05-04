<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Shop;
use App\Models\Card;
use App\Models\Transaction;
use App\Models\Message;

use App\Models\CardStatus;
use App\Models\ShopCategory;
use App\Models\MessageType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
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
        Shop::factory()->count(10)->create();
        Transaction::factory()->count(100)->create();
        Message::factory()->count(100)->create();
    }
}
