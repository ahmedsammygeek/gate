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
use Str;
use Notification;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Transaction;
use App\Models\Course;
use App\Models\UserCourse;
use App\Models\UserInstallments;
use App\Models\Setting;
use App\Notifications\NotifyAdminWithNewPurchase;
use App\Notifications\NotifyAdminWithInstallmentPaid;
use App\Notifications\NotifyAdminWithNewTransaction;
class CheckoutController extends Controller
{

    public $mfConfig = [];

    /**
     * Display a listing of the resource.
     */
    public function pay(Order $order)
    {
        // check if  this order is already paid
        if ($order->is_paid == 1 ) {
            $status = 'success';
            $message = 'تم دفع الطلب بالفعل';
            $order_number = $order->order_number;
            return redirect(url('https://frontend.thegatelearning.com/confirm?message='.$message.'&status='.$status.'&order='.$order_number));
        } 

        // in case of the course is free
        if (($order->amount_due_today == 0 ) && ($order->amount == 0 )) {
            $order->is_paid = 1;
            $order->save();
            $purchase = $this->addPurchaseToUser($order);
            $this->addCoursesToUser($purchase);
            $status = 'success';
            $message = 'تمت عملهه الشراء بنجاح';
            $order_number = $order->order_number;
            return redirect(url('https://frontend.thegatelearning.com/confirm?message='.$message.'&status='.$status.'&order='.$order_number));
        }

        if ($order->amount_due_today == 0 ) {
            $purchase = $this->addPurchaseToUser($order);
            $this->addCoursesToUser($purchase);
            $this->addInstallmentsToUser($order, $purchase );
            $status = 'success';
            $message = 'تمت عملهه الشراء بنجاح';
            $order_number = $order->order_number;
            return redirect(url('https://frontend.thegatelearning.com/confirm?message='.$message.'&status='.$status.'&order='.$order_number));
        }



        // if he choosed one_later_installment it means we do not need a payment method to choose
        if ($order->payment_type == 'one_later_installment' ) {
            $purchase = $this->addPurchaseToUser($order);
            $this->addCoursesToUser($purchase);
            $this->addInstallmentsToUser( $order , $purchase);
            $status = 'success';
            $message = 'تمت عملهه الشراء بنجاح';
            $order_number = $order->order_number;
            return redirect(url('https://frontend.thegatelearning.com/confirm?message='.$message.'&status='.$status.'&order='.$order_number));
        }


        // if (($order->payment_type == 'one_payment') && ($order->payment_method == 3) ) {
        //     // code...
        // }

        $order->load(['course'  , 'user' ]);
        switch ($order->payment_method) {
            case 1:
            return $this->preparBankMisrPaymentLink($order);
            break;
            case 2:
            return $this->preparMyFatooraPaymentLink($order);
            break;
            case 3:
            return $this->preparBankTransferPayment($order);
            break;
            default:
            break;
        }
    }


    private function preparBankTransferPayment($order)
    {

        $purchase =  $this->addPurchaseToUser($order);
        $this->addCoursesToUser($purchase);
        $this->addInstallmentsToUser($order , $purchase );
        $settings = Setting::first();
        $message = $settings->bank_transfer_message;
        $status = 'success';
        $order_number = $order->order_number;
        return redirect(url('https://frontend.thegatelearning.com/confirm?message='.$message.'&status='.$status.'&order='.$order_number));

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
            'InvoiceValue'       => $order->amount_due_today,
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
                $purchase = $this->addPurchaseToUser($order);
                $this->saveTransactionDetails($purchase);
                $this->addInstallmentsToUser($order , $purchase );
                $this->addCoursesToUser($purchase);
                $message = 'تمت عليه الدفع بنجاح';
                $status = 'success';
                $order_number = $order->order_number;
                return redirect(url('https://frontend.thegatelearning.com/confirm?message='.$message.'&status='.$status.'&order='.$order_number));
            }
            $message = 'تم الدفع بنجاح';
            $status = 'success';
            $order_number = $order->order_number;
            return redirect(url('https://frontend.thegatelearning.com/confirm?message='.$message.'&status='.$status.'&order='.$order_number));
        }

        $message = 'لم يتم العثور على الطلب';
        $status = 'error';
        return redirect(url('https://frontend.thegatelearning.com/confirm?message='.$message.'&status='.$status));
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
                'amount' => $order->amount_due_today ,
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
                'amount' => $order->amount_due_today ,
                'currency' => 'SAR'
            ], 
        ];
        curl_setopt($curl, CURLOPT_URL, 'https://banquemisr.gateway.mastercard.com/api/rest/version/77/merchant/'.$merchantID.'/order/'.$order->order_number);
        curl_setopt($curl, CURLOPT_USERPWD, 'merchant.' . $merchantID . ':' . $merchantPassword . '');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $jsonData = json_decode($response);

        if ($jsonData->status  != 'CAPTURED'  ) {
            $status = 'error';
            $message = 'تم الدفع بنجاح';
            $order_number = $order->order_number;
            return redirect(url('https://frontend.thegatelearning.com/confirm?message='.$message.'&status='.$status.'&order='.$order_number));
        }
        $order->is_paid = 1;
        $order->invoice_id = null ;
        $order->payment_id = $request->resultIndicator ;
        $order->response_data = json_encode($jsonData);
        $order->save();
        $purchase = $this->addPurchaseToUser($order);
        $this->saveTransactionDetails($purchase);
        $this->addInstallmentsToUser($order , $purchase );
        $this->addCoursesToUser($purchase);

        // dd('done now bank_misr cllable')
        $status = 'success';
        $message = 'تمت عمليه الدفع بنجاح';
        $order_number = $order->order_number;
        return redirect(url('https://frontend.thegatelearning.com/confirm?message='.$message.'&status='.$status.'&order='.$order_number));


    }


    public  function saveTransactionDetails(Purchase $purchase)
    {
        $purchase->load('order');
        if ($purchase->order->payment_method == 1 ||  $purchase->order->payment_method == 2 ) {
            $transaction = new Transaction;
            $transaction->user_id = $purchase->order->user_id;
            $transaction->purchase_id = $purchase->id;
            $transaction->amount = $purchase->order?->amount_due_today;
            $transaction->payment_method = ($purchase->order->payment_method == 1 ? 'bank_misr' : 'my_fatoorah') ;
            $transaction->payment_id = $purchase->order?->payment_id;
            $transaction->invoice_id = $purchase->order?->invoice_id;
            $transaction->payment_date = Carbon::now();
            $transaction->added_by = $purchase->order->user_id;
            $transaction->payment_response = $purchase->order->response_data;
            if ($purchase->order->payment_type == 'installments' ) {
                // we need first to check if first installment need to pay today or not (days will be 0)
                if ($purchase->order->course->installments()->where('days' , 0 )->first() ) {
                    $transaction->user_installment_id = $purchase->order->course->installments()->where('days' , 0 )->first()?->id;
                }
            }
            $transaction->save();


            $users = User::permission(['notifications.installments.pay'])->get();
            Notification::send($users,  (new NotifyAdminWithNewTransaction($transaction)) );
        }
        return true;
    }

    public function addPurchaseToUser(Order $order)
    {
        $purchase = new Purchase;
        $purchase->order_id = $order->id;
        $purchase->purchase_number = time().$order->id.$order->user_id;
        $purchase->user_id = $order->user_id;
        $purchase->subtotal = $order->amount;
        $purchase->total = $order->amount;
        $purchase->purchase_type = $order->payment_type;
        switch ($order->payment_type) {
            case 'installments':
            switch ($purchase->order->payment_method) {
                case 3:
                $purchase->is_paid = 0 ;
                break;
                case 2:
                $purchase->is_paid = 1 ;
                break;
                case 1:
                $purchase->is_paid = 1 ;
                break;
            }
            break;
            case 'one_later_installment':
            $purchase->is_paid = 0 ;
            break;
            case 'one_payment':
            switch ($purchase->order->payment_method) {
                case 3:
                $purchase->is_paid = 0 ;
                break;
                case 2:
                $purchase->is_paid = 2 ;
                break;
                case 1:
                $purchase->is_paid = 2 ;
                break;
            }
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

        // here we need to push th notifcation 

        $users = User::permission(['notifications.purchases.new'])->get();
        Notification::send($users,  (new NotifyAdminWithNewPurchase($purchase)) );



        return $purchase;       
    }

    public function addCoursesToUser(Purchase $purchase)
    {
        $purchase->load(['items' , 'order' , 'user']);
        

        $allowed = 0;

        switch ($purchase->order->payment_type) {
            case 'installments':
            switch ($purchase->order->payment_method) {
                case 3:
                $allowed = 0 ;
                break;
                case 2:
                $allowed = 1 ;
                break;
                case 1:
                $allowed = 1 ;
                break;
            }
            break;
            case 'one_later_installment':
            $allowed = 1 ;
            break;
            case 'one_payment':
            switch ($purchase->order->payment_method) {
                case 3:
                $allowed = 0 ;
                break;
                case 2:
                $allowed = 1 ;
                break;
                case 1:
                $allowed = 1 ;
                break;
            }
            break;
        }

        // we need to get items from this purchase
        foreach ($purchase->items as $purchase_item) {
            if ($purchase_item->item_type == 1 ) {
                $user_courses = [];

                $course = Course::find($purchase_item->item_id);
                $user_courses[] = new UserCourse([
                    'course_id' => $purchase_item->item_id , 
                    'expires_at' => $course->ends_at,
                    'course_type' => 1 , 
                    'allowed' => $allowed , 
                ]);

                $purchase->user->courses()->saveMany($user_courses);
            } else {
                $user_courses = [];
                $package = Course::with('courses.subCourse')->find($purchase_item->item_id);

                $user_courses[] = new UserCourse([
                    'course_id' => $package->id , 
                    'expires_at' => $package->ends_at,
                    'course_type' => 2 , 
                    'allowed' => $allowed , 
                ]);
                foreach ($package->courses as $package_course) {
                    $user_courses[] = new UserCourse([
                        'course_id' => $package_course->sub_course_id , 
                        'expires_at' => $package->ends_at,
                        'course_type' => 1 , 
                        'related_package_id' => $package->id , 
                        'allowed' => $allowed , 
                    ]);
                }
                $purchase->user->courses()->saveMany($user_courses);
            }
        }

        return true;
    }


    private function addInstallmentsToUser($order , $purchase )
    {
        if ($order->payment_method != 0 ) {
            switch ($order->payment_method) {
            // bank transfer payment
                case 3:
                $user_installments = [];
                $user_installments[] = new UserInstallments([
                    'user_id' => $order->user_id , 
                    'installment_number' => Str::uuid() , 
                    'course_id' => $order->course_id , 
                    'amount' => $order->course?->price_later , 
                    'due_date' => Carbon::today() , 
                    'status' => 0 , 
                    'purchase_id' => $purchase->id , 
                ]);
                $order->user->installments()->saveMany($user_installments);
                break;
                case 2:
                case 1:
                switch ($order->payment_type) {
                    case 'installments':
                    $user_installments = [];
                    $course_installments = $order->course?->installments()->where('days' , '!=' , 0 )->get();
                    foreach ($course_installments as $course_installment) {
                        $user_installments[] = new UserInstallments([
                            'user_id' => $order->user_id , 
                            'installment_number' => Str::uuid() , 
                            'course_id' => $order->course_id , 
                            'amount' => $course_installment->amount , 
                            'due_date' => Carbon::today()->addDays($course_installment->days) , 
                            'status' => 0 , 
                            'purchase_id' => $purchase->id , 
                        ]);
                    }

                    $order->user->installments()->saveMany($user_installments);
                    break;
                    case 'one_later_installment':
                    $user_installments = [];
                    $user_installments[] = new UserInstallments([
                        'user_id' => $order->user_id , 
                        'installment_number' => Str::uuid() , 
                        'course_id' => $order->course_id , 
                        'amount' => $order->course?->price_later , 
                        'due_date' => Carbon::today()->addDays($order->course?->days) , 
                        'status' => 0 , 
                        'purchase_id' => $purchase->id , 
                    ]);
                    $order->user->installments()->saveMany($user_installments);
                    break;
                }
                break;
            }
        } else {
            $user_installments = [];
            $user_installments[] = new UserInstallments([
                'user_id' => $order->user_id , 
                'installment_number' => Str::uuid() , 
                'course_id' => $order->course_id , 
                'amount' => $order->course?->price_later , 
                'due_date' => Carbon::today()->addDays($order->course?->days) , 
                'status' => 0 , 
                'purchase_id' => $purchase->id , 
            ]);
            $order->user->installments()->saveMany($user_installments);
        }
        // this means he will pay with installments and with bank transfer
        
        return true;
    }

}
