<?php

namespace App\Http\Requests;

class UpdatePasswordRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'new_password' => 'required',
            'code' => 'required',
            'email' => 'required|email|exists:users,email'
        ];
    }
}
