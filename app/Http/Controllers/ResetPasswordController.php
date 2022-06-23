<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\VerifyResetPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;

use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

use App\Models\User;
use App\Models\ResetPasswordCode;

use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $this->sendResetPasswordMail($user);
        return $this->jsonSuccess();
    }

    public function verifyPasswordReset(VerifyResetPasswordRequest $request) {
        $code = ResetPasswordCode::where('email', $request->email)
        ->where('code', $request->code)
        ->first();

        if (!$code) {
            $this->jsonAbort('Wrong code', 404);
        }
        return $this->jsonSuccess();
    }

    public function updatePassword(UpdatePasswordRequest $request) {
        $code = ResetPasswordCode::where('email', $request->email)
        ->where('code', $request->code)
        ->first();
        if (!$code) {
            $this->jsonAbort('Wrong code', 404);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = $request->new_password;
        $user->save();
        ResetPasswordCode::where('email', $request->email)->delete();
        
        return $this->jsonSuccess();
    }

    private function sendResetPasswordMail($user) {
        $code = $this->generateCode(5);
        ResetPasswordCode::create([
            'email' => $user->email,
            'code' => $code,
            'expires_at' => Carbon::tomorrow(),
        ]);
        Mail::to($user->email)->send(new ResetPasswordMail($code));
    }
}
