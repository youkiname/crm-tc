<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\PollVote;

class PollChoiceResource extends JsonResource
{
    
    public function toArray($request)
    {
        $selected = PollVote::where('user_id', $request->user_id)
        ->where('choice_id', $this->id)
        ->exists();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'selected' => $this->when($selected, $selected)
        ];
    }
}
