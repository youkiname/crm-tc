<?php

namespace Tests\Feature;

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
        $response->assertStatus(200);
        $response = $this->get('/api/statistic/transactions/sum/today');
        $response->assertStatus(200);
        $response = $this->get('/api/statistic/transactions/sum/month');
        $response->assertStatus(200);
    }

    public function testTransactionAvg()
    {
        $response = $this->get('/api/statistic/transactions/average_sum/today');
        $response->assertStatus(200);
        $response = $this->get('/api/statistic/transactions/average_sum/month');
        $response->assertStatus(200);
    }

    public function testVisitors()
    {
        $response = $this->get('/api/statistic/visitors/today');
        $response->assertStatus(200);
        $response = $this->get('/api/statistic/visitors/month');
        $response->assertStatus(200);
    }
}
