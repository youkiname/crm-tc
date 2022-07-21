<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\Fluent\AssertableJson;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function auth($role='customer')
    {
        $params = "?email=" . $role . '@mail.ru&password=123123123';
        $response = $this->getJson('/api/auth/' . $params)
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('token')->etc()
        );
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $response['token'],
            'Accept' => 'application/json'
        ]);
        return $response['token'];
    }
}
