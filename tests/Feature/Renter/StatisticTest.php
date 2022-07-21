<?php

namespace Tests\Feature\Renter;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\ShoppingCenter;

class StatisticTest extends TestCase
{

    public function testShops()
    {
        $this->auth('renter');
        $response = $this->get('/api/admin/statistic/shops');
        $response->assertStatus(403);
    }

    public function testCustomers()
    {
        $this->auth('renter');
        $response = $this->get('/api/renter/statistic/customers');
        $response->assertStatus(200);
    }

    public function testTransactionSum()
    {
        $this->auth('renter');
        $response = $this->get('/api/renter/statistic/transactions/sum');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/renter/statistic/transactions/sum', [
            'start_date' => '2020-01-01',
            'end_date' => '2022-01-01',
        ]);
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/renter/statistic/transactions/sum/today');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/renter/statistic/transactions/sum/month');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
    }

    public function testTransactionAvg()
    {
        $this->auth('renter');
        $response = $this->get('/api/renter/statistic/transactions/average_sum/today');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/renter/statistic/transactions/average_sum/month');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
    }

    public function testVisitorsAmount()
    {
        $this->auth('renter');
        $response = $this->get('/api/renter/statistic/visitors/today');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/renter/statistic/visitors/month');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
    }

    public function testVisitorCreating() 
    {
        $this->auth('renter');
        $response = $this->postJson('/api/customer/statistic/visitors', [
            'user_id' => User::inRandomOrder()->first()->id,
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
        ]);
        $response->assertStatus(403);
    }
}
