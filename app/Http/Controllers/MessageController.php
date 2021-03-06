<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\MessageResource;
use App\Http\Resources\MessagesResource;

use App\Models\Message;

class MessageController extends Controller
{

    public function index(Request $request)
    {
        $collection = Message::where('type_id', 1);
        if($request->receiver_id) {
            $collection->where('receiver_id', $request->receiver_id);
        }
        if($request->sender_id) {
            $collection->where('sender_id', $request->sender_id);
        }
        if($request->order_by) {
            $collection->orderBy($request->order_by);
        }
        return new MessagesResource($collection->get());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Message $message)
    {
        return new MessageResource($message);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
