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
            'email' => 'required|email|exists:users,email',
            'code' => 'required|integer'
        ];
    }
}
