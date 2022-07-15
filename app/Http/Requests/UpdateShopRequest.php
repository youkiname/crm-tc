<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string',
            'avatar' => 'image',
            'category_id' => 'integer|exists:shop_categories,id',
            'renter_name' => 'string',
            'renter_phone' => 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',
            'renter_email' => 'email',
            'renter_password' => 'string'
        ];
    }
}
