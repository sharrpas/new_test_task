<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'mobile' => 'required',//or mobile number
            'password' => 'required'
        ]);
        if ($validated_data->fails())
            return $this->error(Status::VALIDATION_FAILED, $validated_data->errors()->first());


        if (!$user = User::query()
            ->where('username', $request->username)
            ->orWhere('mobile', $request->username)
            ->first()) {
            return $this->error(Status::AUTHENTICATION_FAILED, 'نام کاربری یا رمز عبور اشتباه است');
        }

        $pass_check = Hash::check($request->password, $user->password);

        if ($user && $pass_check) {
            return $this->success([
                'user' => $user->name,
                'gym_name' => $user->gym()->first()->name ?? null,
                'username' => $user->username,
                'role' => $user->roles()->first()->name,
                'token' => $user->createToken('token_base_name')->plainTextToken
            ]);
        } else {
            return $this->error(Status::AUTHENTICATION_FAILED, 'نام کاربری یا رمز عبور اشتباه است');
        }

    }
}
