<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVisitorRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'shopping_center_id' => 'required|integer|exists:shopping_centers,id',
        ];
    }
}
