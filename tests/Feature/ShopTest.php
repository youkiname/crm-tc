<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Shop;

class ShopTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/api/shops');
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $response = $this->get('/api/shops', ['id' => Shop::inRandomOrder()->first()->id]);
        $response->assertStatus(200);
    }
}
