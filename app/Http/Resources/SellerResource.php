<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
