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
            'threshold' => $request->threshold,
            'description' => $request->description ?? '',
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
        $bronzeCardStatusId = 1;
        if ($request->name) {
            $cardStatus->name = $request->name;
        }
        if ($request->cashback) {
            $cardStatus->cashback = $request->cashback;
        }
        if ($request->threshold && $cardStatus->id != $bronzeCardStatusId) {
            // Нельзя изменять порог входа в бронзовый статус
            $cardStatus->threshold = $request->threshold;
        }
        if ($request->description) {
            $cardStatus->description = $request->description;
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
