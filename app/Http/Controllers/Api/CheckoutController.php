<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Order;
use App\Models\Setting;
use App\Models\UserCourse;
use App\Http\Requests\Api\CheckoutRequest;
use App\Http\Requests\Api\CheckoutStep2Request;
use App\Http\Resources\BasicCourseResource;
use App\Http\Resources\Api\Settings\PaymentSettingsResource;
use Str;
use Auth;
use Validator;
use Carbon\Carbon;
use App\Http\Resources\Api\CourseInstallmentResource;
use Illuminate\Validation\Rule;
class CheckoutController extends Controller
{

    public $mfConfig = [];

    public function index(CheckoutRequest $request)
    {


        $course = Course::find($request->course_id);
        if (!$course) {
            return response()->json([
                'status' => false,
                'message' => 'we can not find this course',
                'data' =>  []
            ]);
        }

        if (!$course->is_active) {
            return response()->json([
                'status' => false,
                'message' => 'this course can not be purchased',
                'data' =>  []
            ]);
        }


        if ($course->ends_at <= Carbon::today() ) {
            return response()->json([
                'status' => false,
                'message' => 'this course is expired and can not be purchased',
                'data' =>  []
            ]);
        }


        $payment_types['one_payment']['total'] =  $course->getPrice();
        $payment_types['one_payment']['amount_due_today'] = $course->getPrice();
        $payment_types['one_payment']['first_payment_date'] = Carbon::today()->toDateString();

        if ($course->price_later) {
            $payment_types['one_later_installment']['total']  = $course->price_later ;
            $payment_types['one_later_installment']['amount_due_today']  = 0 ;
            $payment_types['one_later_installment']['first_payment_date'] = Carbon::today()->addDay($course->days)->toDateString();
        }

        if ($course->installments->count()) {
            $payment_types['installments']['total']  =$course->installments()->sum('amount');
            $payment_types['installments']['installments_details']  = CourseInstallmentResource::collection( $course->installments()->orderBy('days' , 'ASC' )->get()) ;
            $first_installment = $course->installments()->where('days' , 0 )->first();
            $payment_types['installments']['amount_due_today']  = $first_installment ? $first_installment->amount : 0 ;
            if ($first_installment) {
                $payment_types['installments']['first_payment_date']  = Carbon::today()->toDateString();
            } else {
                $first_installment =  $course->installments()->orderBy('days' , 'ASC' )->first();
                $payment_types['installments']['first_payment_date']  = Carbon::today()->addDay($first_installment->days)->toDateString();
            }

        }

        $info = Setting::first();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' =>  (object) [
                'payment_methods' => new PaymentSettingsResource($info) , 
                'courses_details' => new BasicCourseResource($course) , 
                'payment_types' => $payment_types , 
                'can_purchase_this_item' => $this->canPurchaseThisItem($course) , 
            ] , 
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkout(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'payment_type' => [
                'required' , 
                Rule::in(['one_payment', 'one_later_installment' , 'installments' ]),
            ] ,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'يجب اختيار العنصر  و نوع الدفع ',
                'data' =>  []
            ]);
        }

        $course = Course::find($request->course_id);
        if (!$course) {
            return response()->json([
                'status' => false,
                'message' => 'لم يتم العثور على الكورس',
                'data' =>  []
            ]);
        }


        if ($course->ends_at <= Carbon::today() ) {
            return response()->json([
                'status' => false,
                'message' => 'عفوا هذا الكورس منتهى ولا يمكن شراء حاليا',
                'data' =>  []
            ]);
        }



        if ($request->payment_method == 3 && ( ($request->payment_type == 'installments') || ($request->payment_type == 'one_later_installment' ) ) ) {
            return response()->json([
                'status' => false,
                'message' => 'يمكن الدفع عن طريق التحويل البنكى فقط فى حاله دفع المبلغ كامل',
                'data' =>  []
            ]);
        }

        if (!$this->canPurchaseThisItem($course)) {
            return response()->json([
                'status' => false,
                'message' => 'لا يمكنك شراء هذا الكورس & الباقه حيث انها مازلت غير منتهيه فى حسابك',
                'data' =>  []
            ]);
        }

        switch ($request->payment_type) {
            case 'installments':
            // here we need to check if the course has installments or not
            if ($course->installments()->count() == 0 ) {
                return response()->json([
                    'status' => false,
                    'message' => 'هذا الكورس لا يحتوى على اقساط',
                    'data' => [] 
                ]);
            }
            break;
            case 'one_later_installment':
            // here we need to check if the course has installments or not
            if ( ( $course->price_later == null ) || ( $course->price_later == 0 ) ) {
                return response()->json([
                    'status' => false,
                    'message' => 'لا يمكن شراء هذا الكورس عن طريق دفعه مؤجله',
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
                $amount_due_today = 0 ;
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

        if ($amount_due_today > 0 ) {

            $validator = Validator::make($request->all(), [
                'course_id' => 'required',
                'payment_method' => [
                    'required' , 
                    Rule::in([1, 2 , 3]),
                ] ,
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'يجب اختيار وسيله دفع لان يوجد مبلغ بقيمه '.$amount_due_today.' يجب دفعه اليوم',
                    'data' =>  (object) []
                ]);
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



    public function canPurchaseThisItem(Course $course)
    {   
        $user = Auth::user();
        $user_course = UserCourse::where('user_id' , $user->id )->where('course_id' , $course->id )->latest()->first();
        if (!$user_course) {
            return true;
        }

        if ($user_course->expires_at >= Carbon::today() ) {
            return false;
        }
        return true;  
    }






}
