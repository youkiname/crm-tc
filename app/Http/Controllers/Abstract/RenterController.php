<?php

namespace App\Http\Controllers\Abstract;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UpdateProfileRequest;

use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;

use App\Models\User;
use App\Models\Role;

class RenterController extends Controller
{
    private int $roleId;

    public function __construct() {
        $this->roleId = Role::where('name', 'renter')->first()->id;
    }

    public function index()
    {
        $renters = User::where('role_id', $this->roleId)->get();
        return new UsersResource($renters);
    }

    public function show($id)
    {
        $renter = User::where('role_id', $this->roleId)
        ->where('id', $id)->first();
        return new UserResource($renter);
    }

    public function update(UpdateProfileRequest $request, $id)
    {
        $renter = User::where('role_id', $this->roleId)->where('id', $id)->first();
        $renter->first_name = $request->first_name ?? $renter->first_name;
        $renter->last_name = $request->last_name ?? $renter->last_name;
        $renter->phone = $request->phone ?? $renter->phone;
        $renter->birth_date = $request->birth_date ?? $renter->birth_date;
        $renter->email = $request->email ?? $renter->email;
        $renter->email = $request->email ?? $renter->email;
        $renter->gender = $request->gender ?? $renter->gender;
        if ($request->password) {
            $renter->password = Hash::make($request->password);
        }
        $renter->save();
        return new UserResource($renter);
    }

    public function destroy($id)
    {
        User::where('role_id', $this->roleId)->where('id', $id)->delete();
        return $this->jsonSuccess();
    }
}
