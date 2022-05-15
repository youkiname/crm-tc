<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Support\Facades\Hash;

use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;

use App\Models\User;
use App\Models\Card;

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
        
        $collection = User::paginate(15);
        return new UsersResource($collection);
    }

    public function auth(AuthRequest $request)
    {
        $user = User::where('email', $request->email)
        ->where('password', $request->password)
        ->first();
        if(!$user) {
            $this->jsonAbort('User not found', 404);
        }
        return new UserResource($user);
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

        Card::create([
            'user_id' => $user->id,
            'number' => $this->generateCardNumber(),
            'bonuses_amount' => 0,
            'status_id' => 1
        ]);
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

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    private function generateCardNumber() {
        $chars = '01234567890';
        do {
            $code = '';
            for ($x = 0; $x < 16; $x++) {
                $code .= $chars[ rand(0, strlen($chars)-1) ];
            }
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
