<?php

namespace App\Http\Requests;

class UpdateCardStatusRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string',
            'threshold' => 'integer|min:0'
        ];
    }
}
