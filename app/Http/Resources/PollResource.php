<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\PollVote;

class PollResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        $selected = PollVote::where('poll_id', $this->id)
        ->where('user_id', $request->user_id)->exists();
        return [
            'id' => $this->id,
            'shopping_center' => new NestedShoppingCenter($this->shoppingCenter),
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'choices' => new PollChoicesResource($this->choices),
            'selected' => $selected,
        ];
    }
}
