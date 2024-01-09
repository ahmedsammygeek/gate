<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Resources\Api\Settings\SocialResource;
use App\Http\Resources\Api\Settings\PaymentSettingsResource;
class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function social()
    {
        $info = Setting::first();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' =>  [
                'social' => new SocialResource($info) , 
            ]
        ] , 200);
    }

    public function payments()
    {
        $info = Setting::first();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' =>  [
                'payment_methods' => new PaymentSettingsResource($info) , 
            ]
        ] , 200);
    }

}
