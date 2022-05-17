<?php

namespace App\Http\Requests;

class MakeChoiceRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'poll_id' => 'required|integer|exists:polls,id',
            'choice_id' => 'required|integer|exists:poll_choices,id',
        ];
    }
}
