<?php

namespace Tests\Feature\Seller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Shop;
use App\Models\ShoppingCenter;
use App\Models\ShopCategory;

class ShopTest extends TestCase
{
    use WithFaker;

    public function testIndex()
    {
        $this->auth('seller');
        $response = $this->get('/api/admin/shops');
        $response->assertStatus(403);
    }

    public function testShow()
    {
        $this->auth('seller');
        $response = $this->get('/api/admin/shops', ['id' => Shop::inRandomOrder()->first()->id]);
        $response->assertStatus(403);
    }

    public function testCategoriesGetter()
    {
        $this->auth('seller');
        $response = $this->get('/api/shops/categories');
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $this->auth('seller');
        $response = $this->post('/api/admin/shops', [
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
            'name' => "Vadim SHOP",
            'category_id' => ShopCategory::inRandomOrder()->first()->id,
            'renter_name' => 'Вадим Воронов',
            'renter_phone' => '+79998887766',
            'renter_email' => $this->faker->safeEmail(),
            'renter_password' => '123123123',
        ]);
        $response->assertStatus(403);
    }

    public function testDelete()
    {
        $this->auth('seller');
        $testShop = Shop::orderBy('id', 'desc')->first();
        $renterId = $testShop->renter->id;
        $response = $this->delete('/api/admin/shops/' . $testShop->id);
        $response->assertStatus(403);
    }
}
