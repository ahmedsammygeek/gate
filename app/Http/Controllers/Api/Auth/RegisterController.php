<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Resources\ProfileResource;
use App\Models\User;
use App\Models\PhoneCodeVerification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Hash;
use App\Notifications\WelcomeNotification;
use App\Http\Requests\Api\Auth\CheckRegisterRequest;
use App\Channels\WhatsAppChannel;
use Notification;
use App\Notifications\TestNotification;
use Carbon\Carbon;
use App\Http\Resources\UserResource;
class RegisterController extends Controller
{

    public function check_register(CheckRegisterRequest $request)
    {   
        $code = new PhoneCodeVerification;
        $code->code = substr(str_shuffle('0123456789'), 0 , 5 );
        $code->phone = $request->phone;
        $code->save();


        Notification::route('WhatsApp', $request->phone )->notify(new TestNotification($code->code));
        return response()->json([
            'status' => true,
            'message' => 'phone code send successfully',
            'data' => [] , 
        ]);
    }



    public function register(RegisterRequest $request)
    {

        // we need to check first the code 

        $code = PhoneCodeVerification::where([
            ['code' , '=' , $request->code ] , 
            ['phone' , '=' , $request->phone ] , 
        ])->first();

        if (!$code) {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => []
            ]);
        }

        $code->delete();

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->telegram = $request->telegram;
        $user->university_id = $request->university_id;
        $user->group_number = $request->group_number;
        $user->study_type = $request->study_type;
        $user->password = Hash::make($request->password);
        $user->activated_at = Carbon::now();
        $user->save();

        $user->notify(new WelcomeNotification);


        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => (object) [
                                   'user' => UserResource::make($user) , 
                    'token' =>  $user->createToken("UserToken")->plainTextToken , 
            ]
        ]);
    }

}
