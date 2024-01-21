<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserInstallments;

use MyFatoorah\Library\MyFatoorah;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentEmbedded;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use Exception;
use Str;
use Carbon\Carbon;
use App\Models\Transaction;

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

        // dd($installment);

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

                // now we need to update installment status
                $installment->status = 1;
                $installment->transaction_id = $transaction->id;
                $installment->save();

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



}
