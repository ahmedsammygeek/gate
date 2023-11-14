<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
       

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
