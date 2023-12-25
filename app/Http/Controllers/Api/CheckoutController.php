<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Requests\Api\CheckoutRequest;
use App\Http\Requests\Api\CheckoutStep2Request;
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
            $payment_types['one_later_installment']  = $course->one_later_installment_count ;
        }

        if ($course->installments->count()) {
            $payment_types['installments']  = $course->installments()->select('amount' , 'days' )->orderBy('days' , 'ASC' )->get() ;
        }

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' =>  (object) [
                'payment_types' => $payment_types
            ] , 
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkout(CheckoutStep2Request $request)
    {
        $this->mfConfig = [
            'apiKey'      => config('myfatoorah.api_key'),
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];
    }

}
