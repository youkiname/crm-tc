<?php

namespace App\Http\Controllers\Abstract;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(Request $request) {
        $user = $request->user();
        $user->first_name = $request->first_name ?? $user->first_name;
        $user->last_name = $request->last_name ?? $user->last_name;
        $user->phone = $request->phone ?? $user->phone;
        $user->birth_date = $request->birth_date ?? $user->birth_date;
        $user->email = $request->email ?? $user->email;
        return new UserResource($user);
    }
}
