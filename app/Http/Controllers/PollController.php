<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Requests\MakeChoiceRequest;
use App\Http\Requests\CreatePollRequest;
use App\Http\Requests\UpdatePollRequest;

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
             '), [$request->user()->id]
        );
        return new NestedShoppingCenters($centers);
    }

    public function makeChoice(MakeChoiceRequest $request) {
        $exists = PollVote::where('user_id', $request->user()->id)
        ->where('poll_id', $request->poll_id)->exists();
        if ($exists) {
            $this->jsonAbort('Already voted', 409);
        }
        PollVote::create([
            'poll_id' => $request->poll_id,
            'choice_id' => $request->choice_id,
            'user_id' => $request->user()->id,
        ]);

        return $this->jsonSuccess();
    }

    public function store(CreatePollRequest $request)
    {
        $poll = Poll::create([
            'shopping_center_id' => $request->shopping_center_id,
            'title' => $request->title,
            'description' => $request->description ?? '',
        ]);
        $this->createChoices($poll->id, $request->choices);
        return new PollResource($poll);
    }

    public function show(Poll $poll)
    {
        return new PollResource($poll);
    }

    public function update(UpdatePollRequest $request, $id)
    {
        $poll = Poll::find($id);
        $poll->title = $request->title ?? $poll->title;
        $poll->description = $request->description ?? $poll->description;
        $poll->is_active = $request->is_active ?? $poll->is_active;
        $poll->save();

        if ($request->choices) {
            PollChoice::where('poll_id', $poll->id)->delete();
            $this->createChoices($poll->id, $request->choices);
        }

        return new PollResource($poll);
    }

    public function destroy($id)
    {
        Poll::where('id', $id)->delete();
        return $this->jsonSuccess();
    }

    public function activatePoll($id)
    {
        Poll::where('id', $id)->update(['is_active' => 1]);
        return response()->json([
            'success' => true,
        ]);
    }

    public function deactivatePoll($id)
    {
        Poll::where('id', $id)->update(['is_active' => 0]);
        return response()->json([
            'success' => true,
        ]);
    }

    private function createChoices($pollId, $choices) {
        foreach ($choices as $choice) {
            PollChoice::create([
                'poll_id' => $pollId,
                'title' => $choice
            ]);
        }
    }
}
