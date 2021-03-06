<?php

namespace App\Http\Requests;

class UpdateProfileRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'birth_date' => 'date',
            'mobile' => 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/'
        ];
    }
}
