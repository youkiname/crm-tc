<?php

namespace Tests\Feature\Seller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class UserTest extends TestCase
{
    public function testIndex()
    {
        $this->auth('seller');
        $response = $this->get('/api/superadmin/users/');
        $response->assertStatus(403);
    }

    public function testShow()
    {
        $this->auth('seller');
        $response = $this->get('/api/superadmin/users/', ['id' => User::inRandomOrder()->first()->id]);
        $response->assertStatus(403);

        $user_id = User::inRandomOrder()->first()->id;
        $response = $this->get('/api/superadmin/users/' . $user_id);
        $response->assertStatus(403);
    }

    public function testByCardNumber()
    {
        $this->auth('seller');
        $response = $this->get('/api/superadmin/users/', ['card_number' => User::inRandomOrder()->first()->card_number]);
        $response->assertStatus(403);
    }
}
