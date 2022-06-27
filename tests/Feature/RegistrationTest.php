<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class RegistrationTest extends TestCase
{
    use WithFaker;

    public function test_registration()
    {
        $response = $this->postJson('/api/register', [
            'first_name' => 'user',
            'last_name' => 'test',
            'email' => $this->faker()->email(),
            'gender' => 'male',
            'mobile' => '+79209875544',
            'birth_date' => date('Y-m-d'),
            'password' => '123123123',
        ]);

        $response->assertStatus(201);

        User::where('id', $response['id'])->delete();
    }
}
