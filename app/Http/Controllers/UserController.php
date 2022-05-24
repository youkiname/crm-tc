<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\VerifyResetPasswordRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UpdateProfileRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Mail\ResetPasswordMail;

use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;

use App\Models\User;
use App\Models\VerificationCode;
use App\Models\ResetPasswordCode;
use App\Models\Card;
use App\Models\ShoppingCenter;

use Carbon\Carbon;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->id) {
            return $this->show($this->getUserById($request->id));
        }
        if ($request->card_number) {
            return $this->show($this->getUserByCardNumber($request->card_number));
        }
        
        $collection = User::all();
        return new UsersResource($collection);
    }

    public function auth(AuthRequest $request)
    {
        $user = User::where('email', $request->email)
        ->where('password', $request->password)
        ->first();
        return new UserResource($user);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $this->sendResetPasswordMail($user);
        return response()->json([
            'success' => true,
        ]);
    }

    public function verifyPasswordReset(VerifyResetPasswordRequest $request) {
        $code = ResetPasswordCode::where('email', $request->email)
        ->where('code', $request->code)
        ->first();

        if (!$code) {
            $this->jsonAbort('Wrong code', 404);
        }
        return response()->json([
            'success' => true,
        ]);
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
        
        return response()->json([
            'success' => true,
        ]);
    }

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

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = User::find($request->id);
        if ($request->first_name) {
            $user->first_name = $request->first_name;
        }
        if ($request->last_name) {
            $user->last_name = $request->last_name;
        }
        if ($request->birth_date) {
            $user->birth_date = $request->birth_date;
        }
        if ($request->gender) {
            $user->gender = $request->gender;
        }
        if ($request->mobile) {
            $user->mobile = $request->mobile;
        }
        $user->save();
        return new UserResource($user);
    }

    public function destroy($id)
    {
        //
    }

    private function generateCardNumber() {
        do {
            $code = $this->generateCode(16);
        } while (false);
        return $code;
    }

    private function getUserByCardNumber($cardNumber) {
        $card = Card::where('number', $cardNumber)->first();
        if (!$card) {
            $this->jsonAbort('User not found', 404);
        }
        return $card->user;
    }

    private function getUserById($id) {
        $user = User::find($id);
        if (!$user) {
            $this->jsonAbort('User not found', 404);
        }
        return $user;
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

    private function sendResetPasswordMail($user) {
        $code = $this->generateCode(5);
        ResetPasswordCode::create([
            'email' => $user->email,
            'code' => $code,
            'expires_at' => Carbon::tomorrow(),
        ]);
        Mail::to($user->email)->send(new ResetPasswordMail($code));
    }

    private function generateVerificationCode() {
        do {
            $code = random_int(10000, 99999);
        } while (false);
        return $code;
    }

    private function generateCode($n) {
        $chars = '01234567890';
        $code = '';
        for ($x = 0; $x < $n; $x++) {
            $code .= $chars[ rand(0, strlen($chars)-1) ];
        }
        return $code;
    }
}
