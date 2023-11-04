<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;


class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with('university')->where("id", auth()->id())->first();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => (object) [
                'user' => ProfileResource::make($user)
            ]
        ]);

    }


    public function store()
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


    public function changePassword()
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



}
