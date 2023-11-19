<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Hash;
use App\Notifications\WelcomeNotification;
class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->telegram = $request->telegram;
        $user->university_id = $request->university_id;
        $user->group_number = $request->group_number;
        $user->study_type = $request->study_type;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->notify(new WelcomeNotification);
       

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => (object) [
                'user' => ProfileResource::make($user) , 
                'token' =>  $user->createToken("UserToken")->plainTextToken , 
            ]
        ]);
    }

}
