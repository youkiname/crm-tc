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
        ];
    }
}
