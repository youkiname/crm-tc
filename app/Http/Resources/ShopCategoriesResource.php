<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ShopCategoriesResource extends ResourceCollection
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return ShopCategoryResource::collection($this->collection);;
    }
}
