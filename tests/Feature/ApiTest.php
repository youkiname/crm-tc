<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Card;
use App\Models\User;
use App\Models\ShoppingCenter;
use App\Models\Shop;
use App\Models\AdsBanner;
use App\Models\Poll;
use App\Models\PollChoice;
use App\Models\PollVote;

class ApiTest extends TestCase
{
    public function testUsers()
    {
        $response = $this->get('/api/users/');
        $response->assertStatus(200);
        $response = $this->get('/api/users/', ['card_number' => Card::inRandomOrder()->first()->number]);
        $response->assertStatus(200);

        $response = $this->get('/api/users/', ['id' => User::inRandomOrder()->first()->id]);
        $response->assertStatus(200);
    }

    public function testUserShow()
    {
        $user_id = User::inRandomOrder()->first()->id;
        $response = $this->get('/api/users/' . $user_id);
        $response->assertStatus(200);

        $null_user_id = User::count() + 1;
        $response = $this->get('/api/users/' . $null_user_id);
        $response->assertStatus(404);
    }

    public function testShoppingCenters()
    {
        $response = $this->get('/api/shopping_centers/');
        $response->assertStatus(200);

        $response = $this->get('/api/shopping_centers/', ['id' => ShoppingCenter::inRandomOrder()->first()->id]);
        $response->assertStatus(200);
    }

    public function testAdsBanners()
    {
        $response = $this->get('/api/banners/');
        $response->assertStatus(200);

        $response = $this->get('/api/banners/', ['limit' => 1]);
        $response->assertStatus(200);

        $response = $this->get('/api/banners/', ['id' => AdsBanner::inRandomOrder()->first()->id]);
        $response->assertStatus(200);
    }

    public function testBonusesUpdating()
    {
        $response = $this->post('/api/cards/update_bonuses', ['offset' => 100]);
        $response->assertStatus(422);
        
        $cardNumber = Card::inRandomOrder()->first()->number;
        $response = $this->post('/api/cards/update_bonuses',
        [
            'offset' => 100,
            'card_number' => $cardNumber
        ]);
        $response->assertStatus(200);
    }

    public function testPolls()
    {
        $response = $this->get('/api/polls');
        $response->assertStatus(200);

        $response = $this->get('/api/polls', ['shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id]);
        $response->assertStatus(200);

        $response = $this->get('/api/polls/shopping_centers');
        $response->assertStatus(200);


        $randomChoice = PollChoice::inRandomOrder()->first();
        $response = $this->post('/api/polls/make_choice',
        [
            'user_id' => User::inRandomOrder()->first()->id,
            'poll_id' => $randomChoice->poll->id,
            'choice_id' => $randomChoice->id,
        ]);
        $response->assertStatus(200);
    }

    public function testShops()
    {
        $response = $this->get('/api/shops');
        $response->assertStatus(200);

        $response = $this->get('/api/shops', ['id' => Shop::inRandomOrder()->first()->id]);
        $response->assertStatus(200);
    }
}
