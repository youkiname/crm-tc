<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VerificationRequest;

use App\Models\VerificationCode;
use App\Models\User;

class VerificationController extends Controller
{
    public function verify(VerificationRequest $request) {
        $user = User::where('email', $request->email)->first();

        $verification = VerificationCode::where('user_id', $user->id)
        ->where('code', $request->code)->exists();
        if (!$verification) {
            $this->jsonAbort('Wrong code');
        }

        $user->email_verified_at = date("Y-m-d H:i:s");
        $user->save();
        
        VerificationCode::where('user_id', $user->id)->delete();
        return response()->json([
            'success' => true,
        ]);
    }
}
