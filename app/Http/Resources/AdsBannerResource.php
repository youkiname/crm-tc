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
            'comment' => $this->comment,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'shop' => [
                'id' => $this->shop->id,
                'name' => $this->shop->name,
                'category' => $this->shop->category->name,
            ],
            'min_balance' => $this->min_balance,
            'max_balance' => $this->max_balance,
            'min_age' => $this->max_balance,
            'max_age' => $this->max_balance,
            'age_range' => $this->min_age . '-' . $this->max_age,
            'gender' => $this->gender,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at
        ];
    }
}
