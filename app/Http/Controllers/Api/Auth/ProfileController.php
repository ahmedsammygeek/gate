<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Api\Auth\ChangeWtsNumberRequest;
use App\Http\Requests\Api\Auth\SendOtpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\Api\Auth\ProfileRequest;
use App\Http\Requests\Api\Auth\ChangePasswordRequest;


class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with('university')->where("id", auth()->id())->first();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => (object) [
                'user' => ProfileResource::collection($user)
            ]
        ]);

    }


    public function store(ProfileRequest $request)
    {
        $data = $request->validated();

        auth()->user()->update([
            'university_id' => $data['university_id'],
            'speciality_id' => $data['speciality_id'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => (object) [
                'user' => ProfileResource::make(auth()->user())
            ]
        ]);

    }


    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->validated();
        if (!Hash::check($data['password'], auth()->user()->password)) {
            return response()->json([
                'status' => false,
                'message' => 'incorrect Password',
                'data' => null
            ], 401);
        }
        auth()->user()->update(['password' => $data['new_password']]);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => null
        ]);
    }


    public function sendOtp(ChangeWtsNumberRequest $request)
    {
        $data = $request->validated();

        $otp = mt_rand(1000, 9999);

        auth()->user()->update(['otp' => $otp]);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => (object) [
                'code' => $otp,
                'phone' => $data['phone']
            ]
        ]);
    }

    public function changeWtsNumber(SendOtpRequest $request)
    {
        $data = $request->validated();

        $user = User::whereId(auth()->id())->where('otp', $data['otp'])->first();

        if (!$user) {
            dd(1);
            return response()->json([
                'status' => false,
                'message' => 'incorrect otp',
                'data' => null
            ], 401);
        }

        dd(2);
        auth()->user()->update([
            'otp' => null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => null
        ]);
    }



}
