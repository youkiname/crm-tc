<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdsBannerResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            // 'image_link' => $this->image_link,
            'image_link' => 'https://picsum.photos/800/400',
            'link' => $this->link,
        ];
    }
}
