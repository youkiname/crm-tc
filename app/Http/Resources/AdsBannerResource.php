<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdsBannerResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'link' => "https://top-sistem.ru",
            'image_link' => 'https://api.top-sistem.ru' . $this->image_link,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'shop' => [
                'id' => $this->shop->id,
                'name' => $this->shop->name,
                'category' => $this->shop->category->name,
            ],
            'is_active' => $this->is_active,
            'created_at' => $this->created_at
        ];
    }
}
