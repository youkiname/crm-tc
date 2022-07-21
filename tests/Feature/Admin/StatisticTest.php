<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\ShoppingCenter;

class StatisticTest extends TestCase
{

    public function testShops()
    {
        $this->auth('admin');
        $response = $this->get('/api/admin/statistic/shops');
        $response->assertStatus(200);
    }

    public function testaCustomers()
    {
        $this->auth('admin');
        $response = $this->get('/api/admin/statistic/customers');
        $response->assertStatus(200);
    }

    public function testTransactionSum()
    {
        $this->auth('admin');
        $response = $this->get('/api/admin/statistic/transactions/sum');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/admin/statistic/transactions/sum', [
            'start_date' => '2020-01-01',
            'end_date' => '2022-01-01',
        ]);
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/admin/statistic/transactions/sum/today');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/admin/statistic/transactions/sum/month');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
    }

    public function testTransactionAvg()
    {
        $this->auth('admin');
        $response = $this->get('/api/admin/statistic/transactions/average_sum/today');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/admin/statistic/transactions/average_sum/month');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
    }

    public function testVisitorsAmount()
    {
        $this->auth('admin');
        $response = $this->get('/api/admin/statistic/visitors/today');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
        $response = $this->get('/api/admin/statistic/visitors/month');
        $response->assertStatus(200)
        ->assertJsonPath('amount', fn ($amount) => is_numeric($amount));
    }

    public function testVisitorCreating() 
    {
        $this->auth('admin');
        $response = $this->postJson('/api/customer/statistic/visitors', [
            'user_id' => User::inRandomOrder()->first()->id,
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
        ]);
        $response->assertStatus(403);
    }
}
