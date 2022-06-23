<?php

namespace Tests\Feature;

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
        $response = $this->get('/api/polls');
        $response->assertStatus(200);

        $response = $this->get('/api/polls', ['shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id]);
        $response->assertStatus(200);
    }

    public function testShoppingCentersGetter()
    {
        $response = $this->get('/api/polls/shopping_centers');
        $response->assertStatus(200);
    }

    public function testMakeChoice()
    {
        $randomChoice = PollChoice::inRandomOrder()->first();
        $userId = User::inRandomOrder()->first()->id;
        $response = $this->post('/api/polls/make_choice',
        [
            'user_id' => $userId,
            'poll_id' => $randomChoice->poll->id,
            'choice_id' => $randomChoice->id,
        ]);
        $response->assertStatus(200);

        $response = $this->post('/api/polls/make_choice',
        [
            'user_id' => $userId,
            'poll_id' => $randomChoice->poll->id,
            'choice_id' => $randomChoice->id,
        ]);
        $response->assertStatus(409);
    }

    public function testCreate()
    {
        $response = $this->post('/api/polls', [
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
            'title' => "TITLE",
            'description' => "DESCRIPTION",
            'choices' => ['choice1', 'choice2'],
        ]);
        $response->assertStatus(201);
    }

    public function testDelete()
    {
        $response = $this->delete('/api/polls/' . ShoppingCenter::orderBy('id', 'desc')->first()->id);
        $response->assertStatus(200);
    }
}
