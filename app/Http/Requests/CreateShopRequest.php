<?php

namespace App\Http\Requests;

class CreateShopRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'avatar' => 'image',
            'name' => 'required',
            'cashback' => 'integer',
            'category_id' => 'required|integer|exists:shop_categories,id',
            'renter_name' => 'required',
            'renter_phone' => 'required|regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',
            'renter_email' => 'required|email',
            'renter_password' => 'required'
        ];
    }
}
