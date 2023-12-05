<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\User;
use App\Models\VerificationCode;
use Cryptommer\Smsir\Smsir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        //اعتبار سنجی درخواست
        $validated_data = Validator::make($request->all(), [
            'mobile' => 'required',//or mobile number
            'password' => 'required'
        ]);
        if ($validated_data->fails())
            return $this->error(Status::VALIDATION_FAILED, $validated_data->errors()->first());


        //پیدا کردن یوزر
        if (!$user = User::query()
            ->orWhere('mobile', $request->mobile)
            ->first()) {
            return $this->error(Status::AUTHENTICATION_FAILED, 'شماره تماس یا رمز عبور اشتباه است');
        }

        //چک کردن پسورد
        $pass_check = Hash::check($request->password, $user->password);

        //ساخت توکن ورود
        if ($user && $pass_check) {
            return $this->success([
                'user' => $user->name,
                'mobile' => $user->mobile,
                'role' => $user->roles()->first()->name,
                'token' => $user->createToken('token_base_name')->plainTextToken
            ]);
        } else {
            return $this->error(Status::AUTHENTICATION_FAILED, 'نام کاربری یا رمز عبور اشتباه است');
        }

    }

    public function requestCode(Request $request)
    {
        //اعتبار سنجی درخواست
        $validated_data = Validator::make($request->all(), [
            'mobile' => 'required|regex:/(09)[0-9]{9}/|size:11',
        ]);
        if ($validated_data->fails())
            return $this->error(Status::VALIDATION_FAILED, $validated_data->errors()->first());

//ساخت کد تایید
        $verification_code = VerificationCode::query()->create([
            'mobile' => $request->mobile,
            'code' => rand(1000, 9999),
        ]);

        //ارسال با سامانه sms.ir
        $send = smsir::Send();
        $parameter = new \Cryptommer\Smsir\Objects\Parameters('CODE', $verification_code->code);
        $parameters = array($parameter);
        $send->Verify($request->mobile, '100000', $parameters);

        return $this->success([
            'کد تایید ارسال شد',
        ]);
    }
    public function sighup(Request $request)
    {
       /* $validated_data = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'unique:App\Models\User,mobile|required|regex:/(09)[0-9]{9}/|size:11',
            'verification_code' => 'required|integer',
            'password' => [Password::required(), Password::min(4)->numbers(), 'confirmed'],
        ]);
        if ($validated_data->fails())
            return $this->error(Status::VALIDATION_FAILED, $validated_data->errors()->first());

        if (!$verification_code = VerificationCode::query()
            ->where('code', $request->verification_code)
            ->where('created_at', '>=', Carbon::now()->subMinute(4))
            ->Where('verified_at', null)
            ->first()) {
            return $this->error(Status::OPERATION_ERROR, 'کد تایید نادرست است');
        }

        if ($verification_code->mobile != $request->mobile) {
            return $this->error(Status::OPERATION_ERROR, 'شماره تلفن وارد شده صحیح نیست');
        }

        $verification_code->update([
            'verified_at' => Carbon::now(),
        ]);

        $user = User::query()->create([
            'name' => $request->name,
            'username' => $request->username,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);
        $user->roles()->attach(Role::query()->where('name', 'user')->first()->id);
*/

    }
}
