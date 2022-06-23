<?php

namespace App\Http\Requests;

class CreateAdsBannerRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'shop_id' => 'required|integer|exists:shops,id',
            'image' => 'required|image',
            'start_date' => 'date',
            'end_date' => 'date',
            'min_age' => 'integer',
            'max_age' => 'integer',
            'min_balance' => 'integer',
            'max_balance' => 'integer',
        ];
    }
}
