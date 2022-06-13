<?php

namespace App\Http\Requests;

class CreateAdsBannerRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'link' => 'required|url',
            'image' => 'required|image',
        ];
    }
}
