<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Requests\MakeChoiceRequest;
use App\Http\Requests\CreatePollRequest;

use App\Http\Resources\PollResource;
use App\Http\Resources\PollsResource;
use App\Http\Resources\NestedShoppingCenters;

use App\Models\ShoppingCenter;

use App\Models\Poll;
use App\Models\PollChoice;
use App\Models\PollVote;

class PollController extends Controller
{
    public function index(Request $request)
    {
        $collection = Poll::all();
        if ($request->shopping_center_id) {
            $collection = Poll::where('shopping_center_id', $request->shopping_center_id)
            ->orderBy('created_at')
            ->get();
        }
        return new PollsResource($collection);
    }

    public function getCenters(Request $request) {
        // Выбираем все ТЦ, для которых есть опросы
        // + добавляем к ним поле unselected_polls_amount, в котором 
        // содержится кол-во опросов для этого тц, которые пользователь не прошёл.
        $centers = DB::select(
            DB::raw('SELECT *, (
            SELECT count(*) FROM `polls` 
            WHERE polls.shopping_center_id = shopping_centers.id AND polls.id NOT IN 
                (SELECT poll_votes.poll_id FROM poll_votes 
                 WHERE poll_votes.user_id=? 
                 GROUP BY poll_votes.poll_id)
            ) as unselected_polls_amount 
            FROM shopping_centers WHERE id IN 
            (SELECT polls.shopping_center_id FROM polls 
             GROUP BY polls.shopping_center_id)
            ORDER BY unselected_polls_amount DESC
             '), [$request->user_id]
        );
        return new NestedShoppingCenters($centers);
    }

    public function makeChoice(MakeChoiceRequest $request) {
        $exists = PollVote::where('user_id', $request->user_id)
        ->where('poll_id', $request->poll_id)->exists();
        if ($exists) {
            $this->jsonAbort('Already voted', 409);
        }
        PollVote::create([
            'poll_id' => $request->poll_id,
            'choice_id' => $request->choice_id,
            'user_id' => $request->user_id,
        ]);

        return $this->jsonSuccess();
    }

    public function create()
    {
        //
    }

    public function store(CreatePollRequest $request)
    {
        $poll = Poll::create([
            'shopping_center_id' => $request->shopping_center_id,
            'title' => $request->title,
            'description' => $request->description ?? '',
        ]);
        foreach ($request->choices as $choice) {
            PollChoice::create([
                'poll_id' => $poll->id,
                'title' => $choice
            ]);
        }
        return new PollResource($poll);
    }

    public function show(Poll $poll)
    {
        return new PollResource($poll);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Poll::where('id', $id)->delete();
        return $this->jsonSuccess();
    }
}
