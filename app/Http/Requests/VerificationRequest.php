<?php

namespace App\Http\Requests;

class VerificationRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'code' => 'required|integer'
        ];
    }
}
