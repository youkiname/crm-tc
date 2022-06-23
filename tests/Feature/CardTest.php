<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Card;
use App\Models\ShoppingCenter;
use App\Models\Shop;
use App\Models\User;

class CardTest extends TestCase
{
    public function testBonusesUpdating()
    {
        $response = $this->post('/api/cards/update_bonuses', ['offset' => 100]);
        $response->assertStatus(422);
        
        $cardNumber = Card::inRandomOrder()->first()->number;
        $response = $this->post('/api/cards/update_bonuses',
        [
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'offset' => 100,
            'amount' => 5000,
            'seller_id' => User::inRandomOrder()->first()->id,
            'card_number' => $cardNumber
        ]);
        $response->assertStatus(200);
    }
}
