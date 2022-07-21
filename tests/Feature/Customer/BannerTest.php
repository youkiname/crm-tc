<?php

namespace Tests\Feature\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\AdsBanner;

class BannerTest extends TestCase
{
    public function testIndex()
    {
        $this->auth('customer');
        $response = $this->get('/api/admin/banners/');
        $response->assertStatus(403);

        $response = $this->get('/api/admin/banners/', ['limit' => 1]);
        $response->assertStatus(403);
    }

    public function testShow()
    {
        $this->auth('customer');
        $response = $this->get('/api/admin/banners/', ['id' => AdsBanner::inRandomOrder()->first()->id]);
        $response->assertStatus(403);
    }
}
