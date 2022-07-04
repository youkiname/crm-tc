<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdsBannerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string',
            'image' => 'image',
            'start_date' => 'date',
            'end_date' => 'date',
            'min_age' => 'integer',
            'max_age' => 'integer',
            'min_balance' => 'integer',
            'max_balance' => 'integer',
        ];
    }
}
