<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Shop;
use App\Models\ShoppingCenter;
use App\Models\ShopCategory;

class ShopTest extends TestCase
{
    use WithFaker;
    
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

    public function testCreate()
    {
        $response = $this->post('/api/shops', [
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
            'name' => "Vadim SHOP",
            'category_id' => ShopCategory::inRandomOrder()->first()->id,
            'renter_name' => 'Вадим Воронов',
            'renter_phone' => '+79998887766',
            'renter_email' => $this->faker->safeEmail(),
            'renter_password' => '123123123',
        ]);
        $response->assertStatus(201);
    }

    public function testDelete()
    {
        $response = $this->delete('/api/shops/' . Shop::orderBy('id', 'desc')->first()->id);
        $response->assertStatus(200);
    }
}
