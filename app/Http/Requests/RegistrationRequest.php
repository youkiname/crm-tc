<?php

namespace App\Http\Requests;

class RegistrationRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'gender' => 'required',
            'mobile' => 'required',
            'birth_date' => 'required',
            'password' => 'required',
            'is_seller' => 'boolean',
        ];
    }
}
