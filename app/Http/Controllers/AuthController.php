<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Mail\AuthVerification;

use App\Http\Resources\AuthenticatedUserResource;
use App\Http\Resources\UserResource;

use App\Models\User;
use App\Models\Role;
use App\Models\AuthVerificationCode;

use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App;

class AuthController extends Controller
{
    /*
    *
    * Пока что можно авторизовать с любой ролью, роут не важен ->
    * чтобы проверить запрет использования апи с разных ролей.
    *
    */
    public function authCustomer(AuthRequest $request) {
        return $this->auth($request, 'customer');
    }

    public function authSeller(AuthRequest $request) {
        return $this->auth($request, 'seller');
    }

    public function authRenter(AuthRequest $request) {
        return $this->auth($request, 'renter');
    }

    public function authAdmin(AuthRequest $request) {
        return $this->auth($request, 'admin');
    }

    public function verifyAuth(VerifyAuthRequest $request) {
        $verification = AuthVerificationCode::where('email', $request->email)
        ->where('code', $request->code)->first();
        if (!$verification) {
            $this->jsonAbort('Wrong code', 404);
        }
        $user = $verification->user;
        $verification->delete();
        Auth::login($user);
        return AuthenticatedUserResource::make($user)->addToken(Auth::refresh());
    }

    public function getMe(Request $request) {
        return new UserResource($request->user());
    }

    public function logout() {
        Auth::logout();
        return $this->jsonSuccess();
    }

    public function refresh()
    {
        $user = Auth::user();
        $token = Auth::refresh();
        return AuthenticatedUserResource::make($user)->addToken($token);
    }

    private function auth(AuthRequest $request, $role)
    {
        $user = User::where('email', $request->email)->first();
        $isTwoFactorAuthEnabled = $user->settings()->two_factor_auth;
        if ($isTwoFactorAuthEnabled) {
            return $this->twoFactorAuth($request, $user);
        }
        return $this->_auth($request);
    }

    private function _auth(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $hoursTTL48 = 60 * 48;
        // set the token to expire after 48 hours
        $token = Auth::setTTL($hoursTTL48)->attempt($credentials);
        if (!$token) {
            return response()->json(['errors' => 'unauthorized'], 401);
        }
        $user = Auth::user();
        return AuthenticatedUserResource::make($user)->addToken($token);
    }

    private function twoFactorAuth(AuthRequest $request, $user)
    {
        if (!Hash::check($request->password, $user->password)) {
            $this->jsonAbort('Wrong email or password', 401);
        }
        $this->sendAuthVerificationCode($user);
        return response()->json([
            'success' => true,
            'message' => 'Verification code was sent to email.'
        ]);
    }

    private function sendAuthVerificationCode($user) {
        $code = $this->generateCode(5);
        if (App::runningUnitTests()) {
            $code = '00000';
        }
        AuthVerificationCode::where('email', $user->email)->delete();
        AuthVerificationCode::create([
            'email' => $user->email,
            'code' => $code,
            'expires_at' => Carbon::tomorrow(),
        ]);
        Mail::to($user->email)->send(new AuthVerification($code));
    }
}
