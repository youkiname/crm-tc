<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ShoppingCenter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatisticTest extends TestCase
{

    public function testShops()
    {
        $response = $this->get('/api/statistic/shops');
        $response->assertStatus(200);
    }

    public function testCustomers()
    {
        $response = $this->get('/api/statistic/customers');
        $response->assertStatus(200);
    }

    public function testTransactionSum()
    {
        $response = $this->get('/api/statistic/transactions/sum');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/statistic/transactions/sum', [
            'start_date' => '2020-01-01',
            'end_date' => '2022-01-01',
        ]);
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/statistic/transactions/sum/today');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/statistic/transactions/sum/month');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
    }

    public function testTransactionAvg()
    {
        $response = $this->get('/api/statistic/transactions/average_sum/today');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/statistic/transactions/average_sum/month');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
    }

    public function testVisitorsAmount()
    {
        $response = $this->get('/api/statistic/visitors/today');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/statistic/visitors/month');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
    }

    public function testVisitorCreating() 
    {
        $response = $this->postJson('/api/statistic/visitors', [
            'user_id' => User::inRandomOrder()->first()->id,
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
        ]);
        $response->assertStatus(200);
    }
}
