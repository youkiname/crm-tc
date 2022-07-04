<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\City;

class CityTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/api/cities');
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $city = City::inRandomOrder()->first();

        $response = $this->get('/api/cities/' . $city->id);
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->post('/api/cities', [
            'name' => 'testCity'
        ]);
        $response->assertStatus(201);
    }

    public function testUpdate()
    {
        $city = City::inRandomOrder()->first();
        $response = $this->put('/api/cities/' . $city->id, [
            'name' => 'testCityUpdated'
        ]);
        $response->assertStatus(200);
    }

    public function testDelete()
    {
        $testCity = City::orderBy('id', 'desc')->first();

        $response = $this->delete('/api/cities/' . $testCity->id);
        $response->assertStatus(200);
    }
}
