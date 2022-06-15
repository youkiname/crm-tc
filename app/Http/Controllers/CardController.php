<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateBonusesRequest;
use App\Http\Resources\CardResource;

use App\Models\Card;
use App\Models\Transaction;


class CardController extends Controller
{
    public function updateBonuses(UpdateBonusesRequest $request)
    {
        $card = Card::where('number', $request->card_number)->first();
        $card->bonuses_amount += $request->offset;
        $card->save();
        $this->createTransaction($card, $request);
        return new CardResource($card);
    }
    
    private function createTransaction($card, $request) {
        Transaction::create([
            'seller_id' => $request->seller_id,
            'customer_id' => $card->user->id,
            'shop_id' => $request->shop_id,
            'bonuses_offset' => $request->offset,
            'amount' => $request->amount,
        ]);
    }
}
