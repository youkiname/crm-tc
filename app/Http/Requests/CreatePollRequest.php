<?php

namespace App\Http\Requests;

class CreatePollRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'shopping_center_id' => 'required|integer|exists:shopping_centers,id',
            'title' => 'required',
            'choices' => 'required|array|min:2',
        ];
    }
}
