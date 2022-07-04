<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePollRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer|exists:polls,id',
            'title' => 'string',
            'description' => 'string',
            'choices' => 'array|min:2',
        ];
    }
}
