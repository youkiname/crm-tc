<?php

namespace Tests\Feature\Renter;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\CardStatus;

class CardStatusTest extends TestCase
{
    public function testIndex()
    {
        $this->auth('renter');
        $response = $this->get('/api/admin/card_statuses');
        $response->assertStatus(403);
    }

    public function testShow()
    {
        $this->auth('renter');
        $response = $this->get('/api/admin/card_statuses/' . CardStatus::inRandomOrder()->first()->id);
        $response->assertStatus(403);
    }

    public function testCreate()
    {
        $this->auth('renter');
        $response = $this->post('/api/admin/card_statuses', [
            'name' => 'test',
            'cashback' => 13,
            'threshold' => '99999'
        ]);
        $response->assertStatus(403);
    }

    public function testUpdate()
    {
        $this->auth('renter');
        $response = $this->put('/api/admin/card_statuses/' . CardStatus::orderBy('id', 'desc')->first()->id, [
            'name' => 'test2',
            'cashback' => 13,
            'threshold' => '88888',
        ]);
        $response->assertStatus(403);
    }

    public function testDelete()
    {
        $this->auth('renter');
        $response = $this->delete('/api/admin/card_statuses/' . CardStatus::orderBy('id', 'desc')->first()->id);
        $response->assertStatus(403);
    }
}
