<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\City;

class CityTest extends TestCase
{
    public function testIndex()
    {
        $this->auth('admin');
        $response = $this->get('/api/admin/cities');
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $this->auth('admin');
        $city = City::inRandomOrder()->first();

        $response = $this->get('/api/admin/cities/' . $city->id);
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $this->auth('admin');
        $response = $this->post('/api/admin/cities', [
            'name' => 'testCity'
        ]);
        $response->assertStatus(201);
    }

    public function testUpdate()
    {
        $this->auth('admin');
        $city = City::inRandomOrder()->first();
        $response = $this->put('/api/admin/cities/' . $city->id, [
            'name' => 'testCityUpdated'
        ]);
        $response->assertStatus(200);
    }

    public function testDelete()
    {
        $this->auth('admin');
        $testCity = City::orderBy('id', 'desc')->first();

        $response = $this->delete('/api/admin/cities/' . $testCity->id);
        $response->assertStatus(200);
    }
}
