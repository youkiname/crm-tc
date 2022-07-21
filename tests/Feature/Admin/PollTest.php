<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\ShoppingCenter;
use App\Models\Poll;
use App\Models\PollChoice;
use App\Models\PollVote;
use App\Models\User;

class PollTest extends TestCase
{
    public function testIndex()
    {
        $this->auth('admin');
        $response = $this->get('/api/admin/polls');
        $response->assertStatus(200);

        $response = $this->get('/api/admin/polls', ['shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id]);
        $response->assertStatus(200);
    }

    public function testShoppingCentersGetter()
    {
        $this->auth('admin');
        $response = $this->get('/api/customer/polls/shopping_centers');
        $response->assertStatus(403);
    }

    public function testMakeChoice()
    {
        $this->auth('admin');
        $randomChoice = PollChoice::inRandomOrder()->first();
        $response = $this->post('/api/customer/polls/make_choice',
        [
            'poll_id' => $randomChoice->poll->id,
            'choice_id' => $randomChoice->id,
        ]);
        $response->assertStatus(403);

        $response = $this->post('/api/customer/polls/make_choice',
        [
            'poll_id' => $randomChoice->poll->id,
            'choice_id' => $randomChoice->id,
        ]);
        $response->assertStatus(403); 
    }

    public function testCreate()
    {
        $this->auth('admin');
        $response = $this->postJson('/api/admin/polls', [
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
            'title' => "TITLE",
            'description' => "DESCRIPTION",
            'choices' => ['choice1', 'choice2'],
        ]);
        $response->assertStatus(201);
    }

    public function testDelete()
    {
        $this->auth('admin');
        $response = $this->delete('/api/admin/polls/' . Poll::orderBy('id', 'desc')->first()->id);
        $response->assertStatus(200);
    }
}