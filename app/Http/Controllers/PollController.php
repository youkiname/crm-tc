<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MakeChoiceRequest;

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

    public function getChats(Request $request) {
        $centers = ShoppingCenter::whereIn('id', function($query) {
            $query->select('shopping_center_id')->from('polls');
        })->get();

    return new NestedShoppingCenters($centers);
    }

    public function makeChoice(MakeChoiceRequest $request) {
        PollVote::create([
            'poll_id' => $request->poll_id,
            'choice_id' => $request->choice_id,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
        //
    }
}
