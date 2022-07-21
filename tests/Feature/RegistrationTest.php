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
        $this->auth('customer');
        $this->post('/api/admin/register_renter', $this->generateUserData())
        ->assertStatus(403);
        $this->post('/api/renter/register_seller', $this->generateUserData())
        ->assertStatus(403);
    }

    public function testSellerRegister() {
        $this->auth('seller');
        $this->post('/api/admin/register_renter', $this->generateUserData())
        ->assertStatus(403);
        $this->post('/api/renter/register_seller', $this->generateUserData())
        ->assertStatus(403);
    }

    public function testRenterRegister() {
        $this->auth('renter');
        $this->post('/api/admin/register_renter', $this->generateUserData())
        ->assertStatus(403);
        $this->post('/api/renter/register_seller', $this->generateUserData())
        ->assertStatus(201);
    }

    public function testAdminRegister() {
        $this->auth('admin');
        $this->post('/api/admin/register_renter', $this->generateUserData())
        ->assertStatus(201);
        $this->post('/api/renter/register_seller', $this->generateUserData())
        ->assertStatus(403);
    }

    private function generateUserData() {
        return [
            'first_name' => 'User',
            'last_name' => 'CreatedByTests',
            'email' => $this->faker()->email(),
            'gender' => 'male',
            'mobile' => '+79209875544',
            'birth_date' => date('Y-m-d'),
            'password' => '123123123',
        ];
    }
}
