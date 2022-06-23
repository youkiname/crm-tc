<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\AdsBanner;

class AdsBannerTest extends TestCase
{
    public function testIndex()
    {
        $token = $this->getAuthToken();

        $response = $this->get('/api/banners/');
        $response->assertStatus(200);

        $response = $this->get('/api/banners/', ['limit' => 1]);
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $response = $this->get('/api/banners/', ['id' => AdsBanner::inRandomOrder()->first()->id]);
        $response->assertStatus(200);
    }
}
