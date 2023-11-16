<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Auth\LoginRequest;


class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (Auth::attempt(['phone' => $data['phone'], 'password' => $data['password']])) {
            $user = Auth::user();

            if ($user->is_banned) {
                return response()->json([
                    'status' => false,
                    'message' => 'please contact admins',
                    'data' => null
                ], 401);
            }

            $token = $user->createToken('UserToken')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => "success",
                'data' => (object) [
                    'user' => ProfileResource::make($user) , 
                    'token' => $token
                ]], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Phone & Password does not match with our record.',
                'data' => null
            ], 401);
        }

    }



    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->currentAccessToken()->delete();
            return response()->json([
                'status' => 'true',
                'message' => "success",
                'data' => null
            ], 200);
        }
    }
}
