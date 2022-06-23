<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;

use App\Http\Resources\UserResource;

use App\Models\User;
use App\Models\ShoppingCenter;
use App\Models\Card;

use Carbon\Carbon;

class RegistrationController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        $role_id = 1;
        if ($request->is_seller) {
            $role_id = 2;
        }
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'birth_date' => $request->birth_date,
            'password' => $request->password,
            'role_id' => $role_id,
        ]);

        if ($request->is_seller) {
            $user->cashback = random_int(5, 30);
        }


        for($i=1; $i<=ShoppingCenter::count(); $i++) {
            Card::create([
                'user_id' => $user->id,
                'shopping_center_id' => $i,
                'number' => $this->generateCardNumber(),
                'bonuses_amount' => 0,
                'status_id' => 1
            ]);
        }
        $this->sendVerificationMail($user);
        return new UserResource($user);
    }

    private function sendVerificationMail($user) {
        $code = $this->generateVerificationCode();
        VerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => Carbon::tomorrow(),
        ]);
        Mail::to($user->email)->send(new EmailVerification($code));
    }

    private function generateVerificationCode() {
        $code = $this->generateCode(5);
        return $code;
    }
}
