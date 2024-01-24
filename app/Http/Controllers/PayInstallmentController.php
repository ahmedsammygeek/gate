<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserInstallments;
use App\Models\User;
use MyFatoorah\Library\MyFatoorah;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentEmbedded;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use Exception;
use Str;
use Notification;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Notifications\NotifyAdminWithInstallmentPaid;
use App\Notifications\NotifyAdminWithNewTransaction;
class PayInstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pay_with_myfatoorah(UserInstallments $installment)
    {
        $installment->load('purchase');
        if ($installment->status == 1 ) {
            dd('this installment is paid indeed');
        }
        $mfConfig = [
            'apiKey'      => config('myfatoorah.api_key'),
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];
        $paymentId = 0;
        $sessionId = null;
        $orderId  = $installment->installment_number ;
        $curlData = [
            'CustomerName'       => $installment->purchase?->user?->name,
            'InvoiceValue'       => $installment->amount,
            'DisplayCurrencyIso' => 'SAR',
            'CustomerEmail'      => $installment->purchase?->user?->email,
            'CallBackUrl'        => route('myfatoorah.installments.callback' , $installment ),
            'ErrorUrl'           => route('myfatoorah.installments.errorCallback' , $installment ),
            'MobileCountryCode'  => substr($installment->purchase->user?->phone, 0 , 2) ,
            'CustomerMobile'     => substr($installment->purchase->user?->phone, 2) ,
            'Language'           => 'ar',
            'CustomerReference'  =>  $installment->purchase->user->id ,
            'SourceInfo'         => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION
        ];
        $mfObj   = new MyFatoorahPayment($mfConfig);
        $payment = $mfObj->getInvoiceURL($curlData, $paymentId, $orderId, $sessionId);

        return redirect($payment['invoiceURL']);
    }


    public function myfatoorah_callback(Request $request , UserInstallments $installment ) {

        $installment->load('purchase');
        $paymentId = request('paymentId');
        $mfConfig = [
            'apiKey'      => config('myfatoorah.api_key'),
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];
        $mfObj = new MyFatoorahPaymentStatus($mfConfig);
        $data  = $mfObj->getPaymentStatus($paymentId, 'PaymentId');

        if ($installment) {
            if ($data->InvoiceStatus === 'Paid' ) {
                // we need first to svae transaction details
                $transaction = new Transaction;
                $transaction->user_id = $installment->user_id;
                $transaction->amount = $installment->amount;
                $transaction->payment_method ='my_fatoorah' ;
                $transaction->payment_id = $request->paymentId;
                $transaction->invoice_id = $data->InvoiceId;
                $transaction->payment_date = Carbon::now();
                $transaction->added_by = $installment->user_id;
                $transaction->payment_response = json_encode($data) ;
                $transaction->purchase_id = $installment->purchase_id;
                $transaction->user_installment_id = $installment->id;
                $transaction->save();

                // now we need to notify admins with new transaction
                $users = User::permission(['notifications.transactions.new'])->get();
                Notification::send($users,  (new NotifyAdminWithNewTransaction($transaction)) );


                // now we need to update installment status
                $installment->status = 1;
                $installment->transaction_id = $transaction->id;
                $installment->save();

                $users = User::permission(['notifications.installments.pay'])->get();
                Notification::send($users,  (new NotifyAdminWithInstallmentPaid($installment)) );

                


                // now we need to check the purchase is completely paid or still there is installments 

                // count all installments in the same purchase id 
                $installments_count_of_this_purchase = UserInstallments::where('purchase_id' , $installment->purchase_id )->count();
                $unpaid_installments_count_of_this_purchase = UserInstallments::where('purchase_id' , $installment->purchase_id )->where('status' , 0 )->count();
                if ($unpaid_installments_count_of_this_purchase == 0 ) {
                    $purchase = $installment->purchase;
                    $purchase->is_paid = 2;
                    $purchase->save();
                }

                $message = 'تمت عليه الدفع بنجاح';
                $status = 'success';
                return redirect(url('https://frontend.thegatelearning.com/installment-confirm?message='.$message.'&status='.$status));
            }
            $message = 'تم الدفع بنجاح';
            $status = 'success';
            return redirect(url('https://frontend.thegatelearning.com/installment-confirm?message='.$message.'&status='.$status));
        }

        $message = 'لم يتم العثور على القسط...برجاء التواصل مع الدعم';
        $status = 'error';
        return redirect(url('https://frontend.thegatelearning.com/installment-confirm?message='.$message.'&status='.$status));
    }


    public function pay_with_bank_misr(UserInstallments $installment) {

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
                'returnUrl' => route('bank_misr_callback.installments.callback' , $installment ) , 
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
                'amount' => $installment->amount ,
                'currency' => 'SAR',
                'description' => 'pay installment number :'.$installment->installment_number,
                'id' => $installment->installment_number ,
            ),
            'customer' => 
            array (
                'email' => $installment->user?->email ,
                'firstName' => $installment->user?->name ,
                'lastName' => ' ',
                'mobilePhone' => $installment->user?->phone ,
                'phone' => $installment->user?->phone ,
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

    public function bank_misr_callback(Request $request , UserInstallments $installment ) {


        $merchantID = 'TESTTHEGATE_ACAD' ;
        $merchantPassword = '28c84d5aa95f3c8149cee8aa68173240' ;

        $curl = curl_init();
        $data = [
            'apiOperation' =>   'CAPTURE' , 
            'transaction' => [
                'amount' => $installment->amount ,
                'currency' => 'SAR'
            ], 
        ];
        curl_setopt($curl, CURLOPT_URL, 'https://banquemisr.gateway.mastercard.com/api/rest/version/77/merchant/'.$merchantID.'/order/'.$installment->installment_number);
        curl_setopt($curl, CURLOPT_USERPWD, 'merchant.' . $merchantID . ':' . $merchantPassword . '');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $jsonData = json_decode($response);

        if ($jsonData->status  != 'CAPTURED'  ) {
            $status = 'error';
            $message = 'لم تتم عمليه الدفع بنجاح....برجاء المحاوله مره اخرى';
            return redirect(url('https://frontend.thegatelearning.com/installment-confirm?message='.$message.'&status='.$status));
        }

        $transaction = new Transaction;
        $transaction->user_id = $installment->user_id;
        $transaction->amount = $installment->amount;
        $transaction->payment_method ='bank_misr' ;
        $transaction->payment_id = $request->resultIndicator;
        $transaction->payment_date = Carbon::now();
        $transaction->added_by = $installment->user_id;
        $transaction->payment_response = json_encode($jsonData);
        $transaction->purchase_id = $installment->purchase_id;
        $transaction->user_installment_id = $installment->id;
        $transaction->save();


        $users = User::permission(['notifications.transactions.new'])->get();
        Notification::send($users,  (new NotifyAdminWithNewTransaction($transaction)) );



        // now we need to update installment status
        $installment->status = 1;
        $installment->transaction_id = $transaction->id;
        $installment->save();


        $users = User::permission(['notifications.installments.pay'])->get();
        Notification::send($users,  (new NotifyAdminWithInstallmentPaid($installment)) );



        // now we need to check the purchase is completely paid or still there is installments 

        // count all installments in the same purchase id 
        $installments_count_of_this_purchase = UserInstallments::where('purchase_id' , $installment->purchase_id )->count();
        $unpaid_installments_count_of_this_purchase = UserInstallments::where('purchase_id' , $installment->purchase_id )->where('status' , 0 )->count();
        if ($unpaid_installments_count_of_this_purchase == 0 ) {
            $purchase = $installment->purchase;
            $purchase->is_paid = 2;
            $purchase->save();
        }
        $status = 'success';
        $message = 'تمت عمليه الدفع بنجاح';
        // dd($status , $message );
        return redirect(url('https://frontend.thegatelearning.com/installment-confirm?message='.$message.'&status='.$status));
    }
}
