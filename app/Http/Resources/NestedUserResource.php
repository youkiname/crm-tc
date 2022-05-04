<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NestedUserResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Short user's info
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->fullName(),
        ];
    }
}
