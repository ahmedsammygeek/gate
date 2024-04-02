<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Api\Auth\ChangeWtsNumberRequest;
use App\Http\Requests\Api\Auth\SendOtpRequest;
use App\Models\User;
use App\Models\Course;
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
use App\Http\Resources\Api\UserPackageResource;
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
        // here is the only purchase courses
        $user_courses = UserCourse::where('user_id' , $user->id )->where('course_type' , 1 )->where('related_package_id' , null)->where('expires_at' ,  '>' , Carbon::today() )->get();
        // here is the package
        $user_packages_ids = UserCourse::where('user_id' , $user->id )->where('related_package_id' , '!=' , null )->where('expires_at' ,  '>' , Carbon::today() )->select('related_package_id' )->groupBy('related_package_id')->pluck('related_package_id')->toArray();


        $user_packages = Course::find($user_packages_ids);

        // return $user_packages;

         $user_courses->map(function($user_course , $key ) use($user) {
            $user_course['purchase_price'] = Purchase::where('user_id' , $user->id )->whereHas('item', function($query) use($user_course ) {
                $query->where('item_id' , $user_course->course_id );
            })->latest()->first()?->total;
        });

        $user_packages->map(function($user_package , $key )  use($user) {
            $user_package['expires_at'] = UserCourse::where('user_id' , Auth::id() )->where('related_package_id' , $user_package->id )->first()?->expires_at ; 
            $user_package['courses'] = UserCourse::where('user_id' , Auth::id() )->where('related_package_id' , $user_package->id )->get();
            $user_package['purchase_price'] = Purchase::where('user_id' , $user->id )->whereHas('item', function($query) use($user_package) {
                $query->where('item_id' , $user_package->course_id );
            })->latest()->first()?->total;
        });

        // dd($user_packages);

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => (object) [
                'courses' => UserCourseRecourse::collection($user_courses) , 
                'packages' => UserPackageResource::collection($user_packages) , 
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
        if (!$user->canUserChangeWhatsAppNumber()) {
            return response()->json([
                'status' => false,
                'message' => 'you can only request to change whats app number every 7 days',
                'data' => [] , 
            ] , 200);
        }




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
            'status' => true,
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

        $overdue_installemnt_before_today =  UserInstallments::where('user_id' , Auth::id() )
        ->where('status' , 0 )
        ->whereDate('due_date' ,   '<=' ,  Carbon::today() )
        ->orderBy('due_date' , 'ASC')
        ->get();
        $upcomming_first_installment = UserInstallments::
        where('user_id' , Auth::id() )
        ->where('status' , 0 )
        ->whereDate('due_date' , '<=' , Carbon::today()->addDays(3) )
        ->orderBy('due_date' , 'ASC')
        ->get();

        $installments = $overdue_installemnt_before_today->merge($upcomming_first_installment);

        $installments->map(function($installment , $key ){

            if ($key == 0 ) {
                $installment->can_pay = true;
            } else {
                $installment->can_pay = false;
            }

            return $installment;

        });

        if (count($installments) == 0 ) {
            return response()->json([
                'status' => true,
                'message' => 'لا يوجد اقساط حاليا يجب دفعها',
                'data' => [
                    'user_installments' => [] ,
                ]
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => [
                'user_installments' => UserInstallmentResource::collection($installments) ,
            ]
        ]);
    }

    public function course_installments(Course $course) {

        // first we need to see if the user bought this course or not

        $user_courses = UserCourse::where('user_id' , Auth::id() )->where('course_id' , $course->id )->latest()->first();

        if (!$user_courses) {
            return response()->json([
                'status' => false,
                'message' => 'انت غير مشترك فى هذا الكورس',
                'data' => []
            ]);
        }


        $installments =  UserInstallments::where('user_id' , Auth::id() )
        ->where('course_id' , $course->id )
        ->orderBy('due_date' , 'ASC')
        ->get();


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
