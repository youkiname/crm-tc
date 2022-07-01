<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class RegistrationTest extends TestCase
{
    use WithFaker;

    public function testCustomerRegister() {
        $this->testRegistration('customer');
    }

    public function testSellerRegister() {
        $this->testRegistration('seller');
    }

    public function testRenterRegister() {
        $this->testRegistration('renter');
    }

    public function testAdminRegister() {
        $this->testRegistration('admin');
    }

    private function testRegistration($roleName)
    {
        $response = $this->postJson('/api/register/' . $roleName, [
            'first_name' => 'User-' . $roleName,
            'last_name' => 'CreatedByTests',
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
