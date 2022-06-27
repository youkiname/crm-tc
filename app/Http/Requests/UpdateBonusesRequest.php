<?php

namespace App\Http\Requests;


class UpdateBonusesRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'card_number' => 'required|exists:users,card_number',
            'offset' => 'required|integer',
            'amount' => 'required|integer',
            'seller_id' => 'required|integer|exists:users,id'
        ];
    }
}
