<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $request->user();
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
}
