<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Role;

class AuthTest extends TestCase
{
    public function testCustomerAuth()
    {
        $this->auth('customer');
    }

    public function testSellerAuth()
    {
        $this->auth('seller');
    }

    public function testRenterAuth()
    {
        $this->auth('renter');
    }

    public function testAdminAuth()
    {
        $this->auth('admin');
    }

    public function testRefresh()
    {
        $this->auth('customer');
        $this->get('api/auth/refresh')->assertJson(fn (AssertableJson $json) =>
            $json->has('token')->etc()
        );;
    }

    public function testTwoFactor()
    {
        $customer = User::where('email', 'customer@mail.ru')->first();
        $settings = $customer->settings();
        $settings->two_factor_auth = 1;
        $settings->save();
        $params = '?email=' . $customer->email . '&password=123123123';
        $this->getJson('api/auth'. $params)->assertJson(fn (AssertableJson $json) =>
            $json->has('success')->etc()
        );;
        $settings->two_factor_auth = 0;
        $settings->save();
    }
}
