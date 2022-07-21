<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\AdsBanner;

class BannerTest extends TestCase
{
    public function testIndex()
    {
        $this->auth('admin');
        $response = $this->get('/api/admin/banners/')->assertStatus(200);
    }

    public function testShow()
    {
        $this->auth('admin');
        $randomBannerId = AdsBanner::inRandomOrder()->first()->id;
        $response = $this->get('/api/admin/banners/', [
            'id' => $randomBannerId
        ]);
        $response->assertStatus(200);
    }
}
