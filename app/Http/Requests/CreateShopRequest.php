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
            'shopping_center_id' => 'required|integer|exists:shopping_centers,id',
            'name' => 'required',
            'cashback' => 'required|integer',
            'category_id' => 'required|integer|exists:shop_categories,id',
        ];
    }
}
