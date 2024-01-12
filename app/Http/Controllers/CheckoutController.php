<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use MyFatoorah\Library\MyFatoorah;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentEmbedded;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Transaction;
use App\Models\Course;
use App\Models\UserCourse;
class CheckoutController extends Controller
{

    public $mfConfig = [];

    /**
     * Display a listing of the resource.
     */
    public function pay(Order $order)
    {

        $order->load(['course'  , 'user' ]);
        switch ($order->payment_method) {
            case 1:
            return $this->preparBankMisrPaymentLink($order);
            break;
            case 2:
            return $this->preparMyFatooraPaymentLink($order);
            break;
            case 3:
            return $this->preparBankTransfer($order);
            break;

            default:
            break;
        }
    }


    private function preparMyFatooraPaymentLink($order)
    {
        $mfConfig = [
            'apiKey'      => config('myfatoorah.api_key'),
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];
        $paymentId = 0;
        $sessionId = null;
        $orderId  = $order->order_number ;
        $curlData = [
            'CustomerName'       => $order->user?->name,
            'InvoiceValue'       => $order->amount,
            'DisplayCurrencyIso' => 'SAR',
            'CustomerEmail'      => $order->user?->email,
            'CallBackUrl'        => route('myfatoorah.callback' , $order ),
            'ErrorUrl'           => route('myfatoorah.callback' , $order ),
            'MobileCountryCode'  => substr($order->user?->phone, 0 , 2) ,
            'CustomerMobile'     => substr($order->user?->phone, 2) ,
            'Language'           => 'ar',
            'CustomerReference'  => 1235465489798,
            'SourceInfo'         => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION
        ];
        $mfObj   = new MyFatoorahPayment($mfConfig);
        $payment = $mfObj->getInvoiceURL($curlData, $paymentId, $orderId, $sessionId);

        return redirect($payment['invoiceURL']);
    }



    public function myfatoorah_callback(Request $request , Order $order ) {

        $paymentId = request('paymentId');
        $mfConfig = [
            'apiKey'      => config('myfatoorah.api_key'),
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];
        $mfObj = new MyFatoorahPaymentStatus($mfConfig);
        $data  = $mfObj->getPaymentStatus($paymentId, 'PaymentId');

        if ($order) {
            if ($data->InvoiceStatus === 'Paid' ) {
                $order->is_paid = 1;
                $order->invoice_id = $data->InvoiceId;
                $order->payment_id = $paymentId;
                $order->response_data = json_encode($data);
                $order->save();
            }
            $this->addPurchaseToUser($order);
        }

        dd($data);

        // here we need to redirect the data to vuejs
    }


    private function preparBankMisrPaymentLink($order)
    {
        $merchantID = 'TESTTHEGATE_ACAD' ;
        $merchantPassword = '28c84d5aa95f3c8149cee8aa68173240' ;
        $curl = curl_init();
        $data = array (
            'apiOperation' => 'INITIATE_CHECKOUT',
            'interaction' => 
            array (
                'merchant' => 
                array (
                    'name' => 'thegatelearning Co',
                    'url' => 'https://frontend.thegatelearning.com/',
                    'logo' => 'https://frontend.thegatelearning.com//images/logo/logo.png',
                ),
                'displayControl' => 
                array (
                    'billingAddress' => 'MANDATORY',
                    'customerEmail' => 'MANDATORY',
                ),
                'timeout' => 1800,
                'timeoutUrl' => 'https://www.google.com',
                'cancelUrl' => 'http://www.google.com',
                'returnUrl' => route('bank_misr_callback.callback' , $order ) , 
                'operation' => 'PURCHASE',
                'style' => 
                array (
                    'accentColor' => '#30cbe3',
                ),
            ),
            'billing' => 
            array (
                'address' => 
                array (
                    'city' => 'St Louis',
                    'stateProvince' => 'MO',
                    'country' => 'USA',
                    'postcodeZip' => '63102',
                    'street' => '11 N 4th St',
                    'street2' => 'The Gateway Arch',
                ),
            ),
            'order' => 
            array (
                'amount' => $order->amount ,
                'currency' => 'SAR',
                'description' => 'PURCHASE course :'.$order->course?->title,
                'id' => $order->order_number ,
            ),
            'customer' => 
            array (
                'email' => $order->user?->email ,
                'firstName' => $order->user?->name ,
                'lastName' => ' ',
                'mobilePhone' => $order->user?->phone ,
                'phone' => $order->user?->phone ,
            ),
        );

        // dd($data);

        curl_setopt($curl, CURLOPT_URL, 'https://banquemisr.gateway.mastercard.com/api/rest/version/72/merchant/'.$merchantID.'/session');
        curl_setopt($curl, CURLOPT_USERPWD, 'merchant.' . $merchantID . ':' . $merchantPassword . '');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($curl);
        curl_close($curl);
        $jsonData = json_decode($response);
        $sessionID  = $jsonData->session->id; 
        return view('test' , compact('sessionID') );
    }


    public function bank_misr_callback(Request $request , Order $order ) {

        $merchantID = 'TESTTHEGATE_ACAD' ;
        $merchantPassword = '28c84d5aa95f3c8149cee8aa68173240' ;

        $curl = curl_init();
        $data = [
            'apiOperation' =>   'CAPTURE' , 
            'transaction' => [
                'amount' => $order->amount ,
                'currency' => 'SAR'
            ], 
        ];
        curl_setopt($curl, CURLOPT_URL, 'https://banquemisr.gateway.mastercard.com/api/rest/version/77/merchant/'.$merchantID.'/order/'.$order->order_number);
        curl_setopt($curl, CURLOPT_USERPWD, 'merchant.' . $merchantID . ':' . $merchantPassword . '');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $jsonData = json_decode($response);

        dd($jsonData);

    }


    public  function saveTransactionDetails(Order $order , Purchase $purchase)
    {
        $transaction = new Transaction;
        $transaction->user_id = $order->user_id;
        $transaction->purchase_id = $purchase->id;
        $transaction->amount = $order->amount;
        $transaction->payment_method = ($order->payment_method == 1 ? 'bank_misr' : 'my_fatoorah') ;
        $transaction->payment_id = $order->payment_id;
        $transaction->invoice_id = $order->invoice_id;
        $transaction->payment_date = Carbon::now();
        $transaction->added_by = $order->user_id;
        $transaction->payment_response = $order->response_data;
        $transaction->save();
        return true;
    }

    public function addPurchaseToUser(Order $order)
    {
        $purchase = new Purchase;
        $purchase->purchase_number = time().$order->id.$order->user_id;

        $purchase->user_id = $order->user_id;
        $purchase->subtotal = $order->amount;
        $purchase->total = $order->amount;
        $purchase->purchase_type = $order->payment_type;

        switch ($order->payment_type) {
            case 'installments':
            $purchase->is_paid = 1 ;
            break;
            case 'one_later_installment':
            $purchase->is_paid = 0 ;
            break;
            case 'one_payment':
            $purchase->is_paid = 2 ;
            break;
        }
        $purchase->save();

        $purchase_items = [];

        $purchase_items[] = new PurchaseItem([
            'item_id' => $order->course_id , 
            'course_original_price' =>   $order->amount , 
            'course_purchase_price' =>  $order->amount , 
            'item_type' => $order->course?->type , 
        ]);

        $purchase->items()->saveMany($purchase_items); 
        $this->saveTransactionDetails($order ,  $purchase);
        $this->addCoursesToUser($purchase);
        return true;       
    }

    public function addCoursesToUser(Purchase $purchase)
    {
        // we need to get items from this purchase
        $purchase->load(['items' , 'user']);
        foreach ($purchase->items as $purchase_item) {
            if ($purchase_item->item_type == 1 ) {
                $user_courses = [];

                $course = Course::find($purchase_item->item_id);
                $user_courses[] = new UserCourse([
                    'course_id' => $purchase_item->item_id , 
                    'expires_at' => $course->ends_at,
                    'course_type' => 1
                ]);

                $purchase->user->courses()->saveMany($user_courses);
            } else {
                $user_courses = [];
                $package = Course::with('courses.subCourse')->find($purchase_item->item_id);

                $user_courses[] = new UserCourse([
                    'course_id' => $package->id , 
                    'expires_at' => $package->ends_at,
                    'course_type' => 2 , 
                ]);
                foreach ($package->courses as $package_course) {
                    $user_courses[] = new UserCourse([
                        'course_id' => $package_course->sub_course_id , 
                        'expires_at' => $package->ends_at,
                        'course_type' => 1 , 
                        'related_package_id' => $package->id , 
                    ]);
                }
                $purchase->user->courses()->saveMany($user_courses);
            }
        }
    }



}
