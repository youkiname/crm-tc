<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdsBannerResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'image_link' => $this->image_link,
            'link' => $this->link,
        ];
    }
}
