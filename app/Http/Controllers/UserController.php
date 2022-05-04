<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;

use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $collection = User::paginate(15);
        return new UsersResource($collection);
    }

    public function auth(Request $request)
    {
        $user = User::where('email', $request->email)
        ->where('password', $request->password)
        ->first();
        if(!$user) {
            return [];
        }
        return new UserResource($user);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        return new UserResource($user);
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
