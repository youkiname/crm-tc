<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\MessageResource;
use App\Http\Resources\MessagesResource;

use App\Models\Message;

class MessageController extends Controller
{

    public function index()
    {
        $collection = Message::paginate(15);
        return new MessagesResource($collection);
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
