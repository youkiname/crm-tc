<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateCardStatusRequest;

use App\Http\Resources\CardStatusesResource;
use App\Http\Resources\CardStatusResource;

use App\Models\CardStatus;

class CardStatusController extends Controller
{
    public function index()
    {
        $collection = CardStatus::all();
        return new CardStatusesResource($collection);
    }

    public function store(UpdateCardStatusRequest $request)
    {
        $status = CardStatus::create([
            'name' => $request->name,
            'cashback' => $request->cashback,
            'threshold' => $request->threshold
        ]);
        return new CardStatusResource($status);
    }

    public function show($id)
    {
        $status = CardStatus::find($id);
        return new CardStatusResource($status);
    }

    public function update(UpdateCardStatusRequest $request, CardStatus $cardStatus)
    {
        if ($request->name) {
            $cardStatus->name = $request->name;
        }
        if ($request->cashback) {
            $cardStatus->cashback = $request->cashback;
        }
        if ($request->threshold) {
            $cardStatus->threshold = $request->threshold;
        }
        $cardStatus->save();
        return new CardStatusResource($cardStatus);
    }

    public function destroy($id)
    {
        CardStatus::where('id', $id)->delete();
        return $this->jsonSuccess();
    }
}
