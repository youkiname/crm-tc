<?php

namespace App\Http\Requests;


class VerifyResetPasswordRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'code' => 'required'
        ];
    }
}
