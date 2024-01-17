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
use Carbon\Carbon;
use App\Http\Resources\Api\CourseInstallmentResource;
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


        $payment_types['one_payment']['total'] =  $course->getPrice();
        $payment_types['one_payment']['amount_due_today'] = $course->getPrice();
        $payment_types['one_payment']['payment_date'] = Carbon::today()->toDateString();

        if ($course->price_later) {
            $payment_types['one_later_installment']['total']  = $course->price_later ;
            $payment_types['one_later_installment']['amount_due_today']  = 0 ;
            $payment_types['one_later_installment']['payment_date'] = Carbon::today()->addDay($course->days)->toDateString();
        }

        if ($course->installments->count()) {
            $payment_types['installments']['total']  =$course->installments()->sum('amount');
            $payment_types['installments']['installments_details']  = CourseInstallmentResource::collection( $course->installments()->orderBy('days' , 'ASC' )->get()) ;
            $first_installment = $course->installments()->where('days' , 0 )->first();
            $payment_types['installments']['amount_due_today']  = $first_installment ? $first_installment->amount : 0 ;
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
        $course = Course::find($request->course_id);
        if (!$course) {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' =>  []
            ]);
        }

        switch ($request->payment_type) {
            case 'installments':
            // here we need to check if the course has installments or not
            if ($course->installments()->count() == 0 ) {
                return response()->json([
                    'status' => false,
                    'message' => 'error this item has no installments',
                    'data' => [] 
                ]);
            }
            break;
            case 'one_later_installment':
            // here we need to check if the course has installments or not
            if ( ( $course->price_later == null ) || ( $course->price_later == 0 ) ) {
                return response()->json([
                    'status' => false,
                    'message' => 'error this item has no one later payment ',
                    'data' => [] 
                ]);
            }
            break;
        }


        $amount = 0;
        $amount_due_today = 0;
        if ($course->getPrice() == 0 ) {
            $amount = 0;
            $amount_due_today = 0;
        } else {
            switch ($request->payment_type) {
                case 'one_payment':
                $amount = $course->getPrice();
                $amount_due_today = $course->getPrice();
                break;
                case 'one_later_installment':
                $amount = $course->price_later;
                $amount_due_today = $course->price_later;
                break;
                case 'installments':
                if ($installment = $course->installments()->where('days'  , 0 )->first() ) {
                    $amount =  $course->installments()->sum('amount') ;
                    $amount_due_today = $installment->amount ;
                } else {
                    $amount = $course->installments()->sum('amount');
                    $amount_due_today =  0 ;
                }
                break;
                default:
                break;
            }
        }


        $order = new Order;
        $order->user_id = Auth::id();
        $order->course_id = $request->course_id;
        $order->payment_type = $request->payment_type;
        $order->payment_method = $request->payment_method;
        $order->order_number = Str::uuid();
        $order->amount = $amount;
        $order->amount_due_today = $amount_due_today;
        $order->save();
        $url = route('orders.pay' , $order );
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' =>  (object) [
                'total' => $order->amount , 
                'amount_due_today' => $order->amount_due_today , 
                'payment_link' => $url , 
            ] , 
        ]);


    }






}
