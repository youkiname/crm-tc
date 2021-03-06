<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;

use App\Http\Resources\UserResource;

use App\Models\User;
use App\Models\Role;
use App\Models\CardAccount;
use App\Models\ShoppingCenter;
use App\Models\VerificationCode;

use Carbon\Carbon;

class RegistrationController extends Controller
{
    public function registerCustomer(RegistrationRequest $request) {
        return $this->register($request, 'customer');
    }

    public function registerSeller(RegistrationRequest $request) {
        return $this->register($request, 'seller');
    }

    public function registerRenter(RegistrationRequest $request) {
        return $this->register($request, 'renter');
    }

    public function registerAdmin(RegistrationRequest $request) {
        return $this->register($request, 'admin');
    }

    private function register(RegistrationRequest $request, $roleName)
    {
        $roleId = Role::where('name', $roleName)->first()->id;

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'card_number' => $this->generateCardNumber(),
            'gender' => $request->gender,
            'phone' => $request->mobile,
            'birth_date' => $request->birth_date,
            'password' => Hash::make($request->password),
            'role_id' => $roleId,
        ]);

        if ($roleName == 'seller') { // seller role_id
            $user->cashback = random_int(5, 30);
        }

        if ($roleName == 'customer' || $roleName == 'renter') {
            $this->generateAccounts($user->id);
        }

        $this->sendVerificationMail($user);
        return new UserResource($user);
    }

    private function generateAccounts($userId) {
        for($i=1; $i<=ShoppingCenter::count(); $i++) {
            CardAccount::create([
                'user_id' => $userId,
                'shopping_center_id' => $i,
                'bonuses_amount' => 0,
            ]);
        }
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
