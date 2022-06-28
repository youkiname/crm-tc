<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Role;

class AuthTest extends TestCase
{
    public function testCustomerAuth()
    {
        $this->testAuth('customer');
    }

    public function testSellerAuth()
    {
        $this->testAuth('seller');
    }

    public function testRenterAuth()
    {
        $this->testAuth('renter');
    }

    public function testAdminAuth()
    {
        $this->testAuth('admin');
    }

    private function testAuth($roleName)
    {
        $roleId = Role::where('name', $roleName)->first()->id;
        $user = User::where('role_id', $roleId)->inRandomOrder()->first();
        $params = '?email=' . $user->email . '&password=' . $user->password;
        $route = '/api/auth/' . $roleName;
        $response = $this->getJson($route . $params);
        $response->assertStatus(200);
    }
}
