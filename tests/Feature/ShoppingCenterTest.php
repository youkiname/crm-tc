<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\ShoppingCenter;

class ShoppingCenterTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/api/shopping_centers/');
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $response = $this->get('/api/shopping_centers/', ['id' => ShoppingCenter::inRandomOrder()->first()->id]);
        $response->assertStatus(200);
    }
}
