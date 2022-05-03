<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionsResource extends ResourceCollection
{
    public function toArray($request)
    {
        return TransactionResource::collection($this->collection);
    }
}
