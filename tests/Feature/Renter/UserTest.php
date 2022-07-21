<?php

namespace Tests\Feature\Renter;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class UserTest extends TestCase
{
    public function testIndex()
    {
        $this->auth('renter');
        $response = $this->get('/api/superadmin/users/');
        $response->assertStatus(403);
    }

    public function testShow()
    {
        $this->auth('renter');
        $response = $this->get('/api/superadmin/users/', ['id' => User::inRandomOrder()->first()->id]);
        $response->assertStatus(403);

        $user_id = User::inRandomOrder()->first()->id;
        $response = $this->get('/api/superadmin/users/' . $user_id);
        $response->assertStatus(403);
    }

    public function testByCardNumber()
    {
        $this->auth('renter');
        $response = $this->get('/api/superadmin/users/', ['card_number' => User::inRandomOrder()->first()->card_number]);
        $response->assertStatus(403);
    }
}
