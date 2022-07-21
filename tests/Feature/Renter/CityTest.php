<?php

namespace Tests\Feature\Renter;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\City;

class CityTest extends TestCase
{
    public function testIndex()
    {
        $this->auth('renter');
        $response = $this->get('/api/admin/cities');
        $response->assertStatus(403);
    }

    public function testShow()
    {
        $this->auth('renter');
        $city = City::inRandomOrder()->first();

        $response = $this->get('/api/admin/cities/' . $city->id);
        $response->assertStatus(403);
    }

    public function testCreate()
    {
        $this->auth('renter');
        $response = $this->post('/api/admin/cities', [
            'name' => 'testCity'
        ]);
        $response->assertStatus(403);
    }

    public function testUpdate()
    {
        $this->auth('renter');
        $city = City::inRandomOrder()->first();
        $response = $this->put('/api/admin/cities/' . $city->id, [
            'name' => 'testCityUpdated'
        ]);
        $response->assertStatus(403);
    }

    public function testDelete()
    {
        $this->auth('renter');
        $testCity = City::orderBy('id', 'desc')->first();

        $response = $this->delete('/api/admin/cities/' . $testCity->id);
        $response->assertStatus(403);
    }
}
