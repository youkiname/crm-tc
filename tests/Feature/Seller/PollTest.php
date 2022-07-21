<?php

namespace Tests\Feature\Seller;

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
        $this->auth('seller');
        $response = $this->get('/api/admin/polls');
        $response->assertStatus(403);

        $response = $this->get('/api/admin/polls', ['shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id]);
        $response->assertStatus(403);
    }

    public function testShoppingCentersGetter()
    {
        $this->auth('seller');
        $response = $this->get('/api/customer/polls/shopping_centers');
        $response->assertStatus(403);
    }

    public function testMakeChoice()
    {
        $this->auth('seller');
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
        $this->auth('seller');
        $response = $this->postJson('/api/admin/polls', [
            'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
            'title' => "TITLE",
            'description' => "DESCRIPTION",
            'choices' => ['choice1', 'choice2'],
        ]);
        $response->assertStatus(403);
    }

    public function testDelete()
    {
        $this->auth('seller');
        $response = $this->delete('/api/admin/polls/' . Poll::orderBy('id', 'desc')->first()->id);
        $response->assertStatus(403);
    }
}
