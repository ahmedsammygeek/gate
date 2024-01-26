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
use Auth;
use Carbon\Carbon;
use App\Http\Resources\Api\UserCourseRecourse;
use App\Models\UserCourse;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Models\UserInstallments;
use App\Models\PhoneCodeVerification;
use App\Http\Resources\Api\UserInstallmentResource;
use App\Http\Resources\Api\UserPurchaseResource;
use App\Http\Resources\Api\UserTransactionResource;
use Notification;
use App\Notifications\TestNotification;
use App\Channels\WhatsAppChannel;

use App\Http\Requests\Api\CheckNewNumberRequest;
class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load('university');
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => (object) [
                'user' => new ProfileResource($user) , 
            ]
        ]);
    }


    public function store(ProfileRequest $request)
    {

        $user = Auth::user();
        $user->university_id = $request->university_id;
        $user->division = $request->division;
        $user->study_type = $request->study_type;
        if ($request->hasFile('image')) {
            $user->image = basename($request->file('image')->store('users'));
        }
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => (object) [
                'user' => ProfileResource::make($user) , 
            ]
        ]);
    }


    public function courses()
    {
        $user = Auth::user();

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => (object) [
                'courses' => UserCourseRecourse::collection($user->courses) , 
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
        ] , 200);
    }

    public function requestToChange() {

        $user = Auth::user();
        // we need now to send otp to user number to verify the first step
        $code = new PhoneCodeVerification;
        $code->code = substr(str_shuffle('0123456789'), 0 , 5 );
        $code->phone = $user->phone;
        $code->save();


        Notification::route('WhatsApp', $user->phone )->notify(new TestNotification($code->code));
        return response()->json([
            'status' => true,
            'message' => 'otp send to your current whats app number to virify it is you ',
            'data' => [] , 
        ] , 200);
    }


    public function verifyOtpForStepTwo(SendOtpRequest $request)
    {
        $user = Auth::user();
        $code = PhoneCodeVerification::where('code' , $request->otp )->where('phone' , $user->phone )->first();
        if (!$code) {
            return response()->json([
                'status' => false,
                'message' => 'otp not correct',
                'data' => [] , 
            ]);
        }
        $code->step = 3;
        $code->save();

        return response()->json([
            'status' => false,
            'message' => 'you are ready now put your new number',
            'data' => [] , 
        ] , 200);
    }

    public function sendOtpToNewNumber(CheckNewNumberRequest $request)
    {
        $user = Auth::user();
        $code = PhoneCodeVerification::where('phone' , $user->phone )->where('step' , 3 )->first();

        if (!$code) {
            return response()->json([
                'status' => false,
                'message' => 'you did not verify the action first',
                'data' => [] , 
            ] , 200);
        }


        $code = new PhoneCodeVerification;
        $code->code = substr(str_shuffle('0123456789'), 0 , 5 );
        $code->phone = $request->phone;
        $code->save();


        Notification::route('WhatsApp', $request->phone )->notify(new TestNotification($code->code));
        return response()->json([
            'status' => true,
            'message' => 'otp send to your new whats app number  ',
            'data' => [] , 
        ]);
    }

    public function verifyNewNumber(ChangeWtsNumberRequest $request)
    {
        $code = PhoneCodeVerification::where('phone' , $request->phone )->where('code' , $request->code )->first();
        if (!$code) {
            return response()->json([
                'status' => false,
                'message' => 'otp is not valid',
                'data' => [] , 
            ]);
        }

        $user = Auth::user();
        $code = PhoneCodeVerification::where('phone' , $user->phone )->where('step' , 3 )->first();
        if ($code) {
            $code->delete();
        }

        $code2 = PhoneCodeVerification::where('phone' , $request->phone )->first();
        if ($code2) {
            $code2->delete();
        }

        $user->phone = $request->phone;
        $user->last_date_number_changed = Carbon::now();
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'number changed successully',
            'data' => [] , 
        ]);

    }



    public function installments() {

        $installments = UserInstallments::where('user_id' , Auth::id() )->get();

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => [
                'user_installments' => UserInstallmentResource::collection($installments) ,
            ]
        ]);
    }


    public function purchases() {

        $purchases = Purchase::with('order.course')->where('user_id' , Auth::id() )->latest()->get();

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => [
                'user_purchases' => UserPurchaseResource::collection($purchases) ,
            ]
        ]);
    }


    public function transactions() {

        $transactions = Transaction::with(['purchase' , 'installment' ])->where('user_id' , Auth::id() )->latest()->get();

        // return $transactions;
        return response()->json([
            'status' => true,
            'message' => '',
            'data' => [
                'user_transactions' => UserTransactionResource::collection($transactions) ,
            ]
        ]);
    }
}
