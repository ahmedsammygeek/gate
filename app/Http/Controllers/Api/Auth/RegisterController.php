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

        $user->_token = $user->createToken("UserToken")->plainTextToken;

        return response()->json([
            'message' => 'success',
            'data' => UserResource::make($user) // Update this line
        ]);
    }
}
