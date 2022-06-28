<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;

use App\Http\Resources\AuthenticatedUserResource;

use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    public function authCustomer(AuthRequest $request) {
        $roleId = Role::where('name', 'customer')->first()->id;
        return $this->auth($request, $roleId);
    }

    public function authSeller(AuthRequest $request) {
        $roleId = Role::where('name', 'seller')->first()->id;
        return $this->auth($request, $roleId);
    }

    public function authRenter(AuthRequest $request) {
        $roleId = Role::where('name', 'renter')->first()->id;
        return $this->auth($request, $roleId);
    }

    public function authAdmin(AuthRequest $request) {
        $roleId = Role::where('name', 'admin')->first()->id;
        return $this->auth($request, $roleId);
    }

    private function auth(AuthRequest $request, $roleId)
    {
        $user = User::where('email', $request->email)
        ->where('password', $request->password)
        ->where('role_id', $roleId)
        ->first();
        if (!$user) {
            $this->jsonAbort('Wrong email or password', 401);
        }
        $token = $user->createToken('api_token')->plainTextToken;
        return AuthenticatedUserResource::make($user)->addToken($token);
    }
}
