<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Order;
use App\Models\Setting;
use App\Http\Requests\Api\CheckoutRequest;
use App\Http\Requests\Api\CheckoutStep2Request;
use App\Http\Resources\BasicCourseResource;
use App\Http\Resources\Api\Settings\PaymentSettingsResource;
use Str;
use Auth;
class CheckoutController extends Controller
{

    public $mfConfig = [];

    public function index(CheckoutRequest $request)
    {
        $course = Course::find($request->course_id);
        if (!$course) {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' =>  []
            ]);
        }

        $payment_types = [
            'one_payment' => $course->getPrice() , 
        ];

        if ($course->one_later_installment_count) {
            $payment_types['one_later_installment']  = $course->price_later ;
        }

        if ($course->installments->count()) {
            $payment_types['installments']  = $course->installments()->select('amount' , 'days' )->orderBy('days' , 'ASC' )->get() ;
        }

        $info = Setting::first();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' =>  (object) [
                'payment_methods' => new PaymentSettingsResource($info) , 
                'courses_details' => new BasicCourseResource($course) , 
                'payment_types' => $payment_types
            ] , 
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkout(CheckoutStep2Request $request)
    {
        $amount = 0;
        $course = Course::find($request->course_id);

        switch ($request->payment_type) {
            case 'one_payment':
            $amount = $course->getPrice();
            break;
            case 'one_later_installment':
            $amount = $course->price_later;
            break;
            case 'installments':
            $installment = $course->installments()->select('amount' , 'days' )->orderBy('days' , 'ASC' )->first();
            $amount = $installment->amount ;
            break;
            default:
            break;
        }


        $order = new Order;
        $order->user_id = Auth::id();
        $order->course_id = $request->course_id;
        $order->payment_type = $request->payment_type;
        $order->payment_method = $request->payment_method;
        $order->order_number = Str::uuid();
        $order->amount = $amount;
        $order->save();

        $url = route('orders.pay' , $order );
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' =>  (object) [
                'payment_link' => $url , 
            ] , 
        ]);


    }






}
