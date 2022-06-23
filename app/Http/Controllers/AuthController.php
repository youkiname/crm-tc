<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function auth(AuthRequest $request)
    {
        $user = User::where('email', $request->email)
        ->where('password', $request->password)
        ->first();
        if (!$user) {
            $this->jsonAbort('Wrong email or password', 401);
        }
        $token = $user->createToken('api_token')->plainTextToken;
        return AuthenticatedUserResource::make($user)->addToken($token);
    }
}
