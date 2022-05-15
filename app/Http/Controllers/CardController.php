<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateBonusesRequest;
use App\Http\Resources\CardResource;

use App\Models\Card;


class CardController extends Controller
{
    public function updateBonuses(UpdateBonusesRequest $request)
    {
        $card = Card::where('number', $request->card_number)->first();
        $card->bonuses_amount += $request->offset;
        $card->save();
        return new CardResource($card);
    }
}
