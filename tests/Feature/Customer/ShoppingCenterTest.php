<?php

namespace Tests\Feature\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\ShoppingCenter;
use App\Models\City;

class ShoppingCenterTest extends TestCase
{
    public function testIndex()
    {
        $this->auth('customer');
        $response = $this->get('/api/superadmin/shopping_centers/');
        $response->assertStatus(403);

        $response = $this->get('/api/customer/shopping_centers/');
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $this->auth('customer');
        $response = $this->get('/api/superadmin/shopping_centers/', ['id' => ShoppingCenter::inRandomOrder()->first()->id]);
        $response->assertStatus(403);

        $response = $this->get('/api/customer/shopping_centers/', ['id' => ShoppingCenter::inRandomOrder()->first()->id]);
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $this->auth('customer');
        $response = $this->post('/api/superadmin/shopping_centers/', [
            'name' => 'SC created by test',
            'address' => 'test address',
            'city' => City::inRandomOrder()->first()->id,
            'lat' => 12.5,
            'long' => 13.5,
        ]);
        $response->assertStatus(403);
    }

    public function testDelete()
    {
        $this->auth('customer');
        $response = $this->delete('/api/superadmin/shopping_centers/' . ShoppingCenter::orderBy('id', 'desc')->first()->id);
        $response->assertStatus(403);
    }
}
