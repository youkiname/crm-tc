<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Card;

class UserTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/api/users/');
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $response = $this->get('/api/users/', ['id' => User::inRandomOrder()->first()->id]);
        $response->assertStatus(200);

        $user_id = User::inRandomOrder()->first()->id;
        $response = $this->get('/api/users/' . $user_id);
        $response->assertStatus(200);

        $null_user_id = 0;
        $response = $this->get('/api/users/' . $null_user_id);
        $response->assertStatus(404);
    }

    public function testByCardNumber()
    {
        $response = $this->get('/api/users/', ['card_number' => Card::inRandomOrder()->first()->number]);
        $response->assertStatus(200);
    }
}
