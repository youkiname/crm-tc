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
            'card_number' => 'required|exists:cards,number',
            'offset' => 'required|integer',
            'shopping_center_id' => 'required|integer|exists:shopping_centers,id',
            'shop_id' => 'required|integer|exists:shops,id',
            'seller_id' => 'required|integer|exists:users,id'
        ];
    }
}
