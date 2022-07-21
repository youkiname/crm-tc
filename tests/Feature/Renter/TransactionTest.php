<?php

namespace Tests\Feature\Renter;

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
        $this->auth('renter');
        $response = $this->get('/api/admin/transactions');
        $response->assertStatus(403);

        $response = $this->get('/api/admin/transactions', [
            'seller_id' => User::first()->id,
            'shopping_center_id' => ShoppingCenter::first()->id,
        ]);
        $response->assertStatus(403);

        $response = $this->get('/api/admin/transactions', [
            'start_date' => '2020-01-01',
            'end_date' => '2022-01-01',
        ]);
        $response->assertStatus(403);
    }

    public function testShow()
    {
        $this->auth('renter');
        $response = $this->get('/api/admin/transactions/' . Transaction::inRandomOrder()->first()->id);
        $response->assertStatus(403);
    }
}
