<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Mail\AuthVerification;

use App\Http\Resources\AuthenticatedUserResource;

use App\Models\User;
use App\Models\Role;
use App\Models\AuthVerificationCode;

use Carbon\Carbon;

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

    public function verifyAuth(VerifyAuthRequest $request) {
        $verification = AuthVerificationCode::where('email', $request->email)
        ->where('code', $request->code)->first();
        if (!$verification) {
            $this->jsonAbort('Wrong code', 404);
        }
        $verification->delete();
        return $this->getAuthenticatedUserData($verification->user);
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
        return $this->getAuthenticatedUserData($user);
    }

    private function twoFactorAuth(AuthRequest $request, $roleId)
    {
        $user = User::where('email', $request->email)
        ->where('password', $request->password)
        ->where('role_id', $roleId)
        ->first();
        if (!$user) {
            $this->jsonAbort('Wrong email or password', 401);
        }
        $this->sendAuthVerificationCode($user);
        return response()->json([
            'success' => true,
        ]);
    }

    private function getAuthenticatedUserData($user) {
        $token = $user->createToken('api_token')->plainTextToken;
        return AuthenticatedUserResource::make($user)->addToken($token);
    }

    private function sendAuthVerificationCode($user) {
        $code = $this->generateCode(5);
        AuthVerificationCode::create([
            'email' => $user->email,
            'code' => $code,
            'expires_at' => Carbon::tomorrow(),
        ]);
        Mail::to($user->email)->send(new AuthVerification($code));
    }
}
