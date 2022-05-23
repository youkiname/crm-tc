<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Poll;
use App\Models\PollVote;

class NestedShoppingCenter extends JsonResource
{
    public static $wrap = null;
    
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'avatar_link' => 'https://picsum.photos/500/500',
        ];
        if ($request->user_id) {
            $data['unselected_polls_amount'] = $this->unselected_polls_amount;
        }
        return $data;
    }
}
