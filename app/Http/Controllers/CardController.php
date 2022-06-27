<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateBonusesRequest;
use App\Http\Resources\CardResource;

use App\Models\Transaction;
use App\Models\User;

class CardController extends Controller
{
    public function updateBonuses(UpdateBonusesRequest $request)
    {
        $customer = User::where('card_number', $request->card_number)->first();
        $seller = User::where('id', $request->seller_id)->first();

        $customerAccount = $customer->account();
        $shop = $seller->jobShop();
        $shopAccount = $shop->renter->account();

        $customerAccount->bonuses_amount += $request->offset;
        $customerAccount->save();

        $shopAccount->bonuses_amount -= $request->offset;
        $shopAccount->save();

        Transaction::create([
            'seller_id' => $seller->id,
            'customer_id' => $customer->id,
            'shop_id' => $seller->jobShop()->id,
            'shopping_center_id' => $shop->shoppingCenter->id,
            'bonuses_offset' => $request->offset,
            'amount' => $request->amount,
        ]);

        return new CardResource($customer->card());
    }
}
