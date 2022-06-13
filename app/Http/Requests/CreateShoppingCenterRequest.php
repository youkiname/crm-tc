<?php

namespace App\Http\Requests;

class CreateShoppingCenterRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'lat' => 'required|numeric',
            'long' => 'required|numeric'
        ];
    }
}
