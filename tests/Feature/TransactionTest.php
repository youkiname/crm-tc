<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Transaction;
use App\Models\ShoppingCenter;
use App\Models\User;

class TransactionTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/api/transactions');
        $response->assertStatus(200);

        $response = $this->get('/api/transactions', [
            'seller_id' => User::first()->id,
            'shopping_center_id' => ShoppingCenter::first()->id,
        ]);
        $response->assertStatus(200);

        $response = $this->get('/api/transactions', [
            'start_date' => '2020-01-01',
            'end_date' => '2022-01-01',
        ]);
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $response = $this->get('/api/transactions/' . Transaction::inRandomOrder()->first()->id);
        $response->assertStatus(200);
    }
}
