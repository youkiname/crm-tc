<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Transaction;

class TransactionTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/api/transactions');
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $response = $this->get('/api/transactions/' . Transaction::inRandomOrder()->first()->id);
        $response->assertStatus(200);
    }
}
