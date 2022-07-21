<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class ResetPasswordTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->email = User::inRandomOrder()->first()->email;
    }

    public function test()
    {
        $this->testReset();
        $this->testVerify();
        $this->testUpdate();
    }

    private function testReset()
    {
        $response = $this->post('/api/users/reset_password', [
            'email' => $this->email
        ])->assertStatus(200);
    }

    private function testVerify()
    {
        $response = $this->call('GET', '/api/users/verify_password_reset', [
            'email' => $this->email,
            'code' => '12345'
        ])
        ->assertStatus(404);

        $response = $this->call('GET', '/api/users/verify_password_reset', [
            'email' => $this->email,
            'code' => '00000'
        ])
        ->assertStatus(200);
    }

    private function testUpdate()
    {
        $response = $this->post('/api/users/update_password', [
            'new_password' => '11111111',
            'code' => '12345',
            'email' => $this->email,
        ])
        ->assertStatus(404);
        
        $response = $this->post('/api/users/update_password', [
            'new_password' => '11111111',
            'code' => '00000',
            'email' => $this->email,
        ])
        ->assertStatus(200);
    }
}
