<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\CardStatus;

class CardStatusTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/api/card_statuses');
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $response = $this->get('/api/card_statuses/' . CardStatus::inRandomOrder()->first()->id);
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->post('/api/card_statuses', [
            'name' => 'test',
            'threshold' => '99999'
        ]);
        $response->assertStatus(201);
    }

    public function testUpdate()
    {
        $response = $this->put('/api/card_statuses/' . CardStatus::orderBy('id', 'desc')->first()->id, [
            'name' => 'test2',
            'threshold' => '88888',
        ]);
        $response->assertStatus(200);
    }

    public function testDelete()
    {
        $response = $this->delete('/api/card_statuses/' . CardStatus::orderBy('id', 'desc')->first()->id);
        $response->assertStatus(200);
    }
}
