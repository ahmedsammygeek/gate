<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Resources\Api\NotificationResource;
class NotificationController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => [
                'notifications' => NotificationResource::collection($user->notifications) ,
            ]
        ], 200);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->unreadNotifications->where('id', $request->notification_id)->markAsRead();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => null
        ], 200);
    }

   
}
