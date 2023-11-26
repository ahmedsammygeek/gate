<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ForgetPasswordStepOneRequest;
use App\Http\Requests\Api\ForgetPasswordStepTwoRequest;
use App\Models\User;
use App\Models\PhoneCodeVerification;
use Hash;
use Notification;
use App\Notifications\TestNotification;
class ForgetPasswordController extends Controller
{



    public function index(ForgetPasswordStepOneRequest $request)
    {
        $user = User::where('phone' , $request->phone )->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'error , this user can not be found ',
                'data' => null
            ]);
        }

        $code = new PhoneCodeVerification;
        $code->code = substr(str_shuffle('0123456789'), 0  , 5);
        $code->phone = $user->phone;
        $code->save();


         Notification::route('WhatsApp', $request->phone )->notify(new TestNotification($code->code));


        return response()->json([
            'status' => true,
            'message' => 'otp send successfully',
            'data' => null
        ]);
    }

    public function update(ForgetPasswordStepTwoRequest $request)
    {
        $code = PhoneCodeVerification::where([
            ['code' , '=' , $request->code ] , 
            ['phone' , '=' , $request->phone ] , 
        ])->first();

        if (!$code) {
            return response()->json([
                'status' => false,
                'message' => 'otp is not valid ',
                'data' => null
            ]);
        }

        $user = User::where('phone' , $request->phone )->first();
        $user->password = Hash::make($request->password);
        $user->save();

        $code->delete();

        return response()->json([
            'status' => true,
            'message' => 'password changed successfully ',
            'data' => null
        ]);
    }
}
