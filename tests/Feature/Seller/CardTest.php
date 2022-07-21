<?php

namespace Tests\Feature\Seller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class CardTest extends TestCase
{
    public function testBonusesUpdating()
    {
        $this->auth('seller');
        $response = $this->post('/api/seller/cards/update_bonuses', ['offset' => 100]);
        $response->assertStatus(422);
        
        $cardNumber = User::where('role_id', 1)->inRandomOrder()->first()->card_number;
        $response = $this->post('/api/seller/cards/update_bonuses',
        [
            'card_number' => $cardNumber,
            'seller_id' => User::where('role_id', 2)->inRandomOrder()->first()->id,
            'offset' => 100,
            'amount' => 5000,
        ]);
        $response->assertStatus(200);
    }
}
