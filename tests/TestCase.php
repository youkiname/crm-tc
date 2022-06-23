<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void 
    {
        parent::setUp();
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getAuthToken(),
            'Accept' => 'application/json'
        ]);
    }

    protected function getAuthToken()
    {
        $response = $this->getJson('/api/auth/?email=vadimv0810@gmail.com&password=123123123')
        ->assertStatus(200);
        return $response['token'];
    }
}
