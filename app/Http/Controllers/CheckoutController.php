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
use App\Models\Order;
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

            default:
               // code...
            break;
        }
    }


    private function preparMyFatooraPaymentLink($order)
    {
        $this->mfConfig = [
            'apiKey'      => config('myfatoorah.api_key'),
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];
        $paymentId = request('pmid') ?: 0;
        $sessionId = request('sid') ?: null;
        $orderId  = request('oid') ?: 147;
        $curlData = $this->getPayLoadData($order);
        $mfObj   = new MyFatoorahPayment($this->mfConfig);
        $payment = $mfObj->getInvoiceURL($curlData, $paymentId, $orderId, $sessionId);

        return redirect($payment['invoiceURL']);

    }


    private function getPayLoadData($order) {
        $callbackURL = route('myfatoorah.callback');
        return [
            'CustomerName'       => $order->user?->name,
            'InvoiceValue'       => $order->amount,
            'DisplayCurrencyIso' => 'SAR',
            'CustomerEmail'      => $order->user?->email,
            'CallBackUrl'        => $callbackURL,
            'ErrorUrl'           => $callbackURL,
            'MobileCountryCode'  => substr($order->user?->phone, 0 , 2) ,
            'CustomerMobile'     => substr($order->user?->phone, 2) ,
            'Language'           => 'ar',
            'CustomerReference'  => 1235465489798,
            'SourceInfo'         => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION
        ];
    }

    private function getTestOrderData($orderId) {
        return [
            'total'    => 1500,
            'currency' => 'SAR'
        ];
    }
    private function getTestMessage($status, $error) {
        if ($status == 'Paid') {
            return 'Invoice is paid.';
        } else if ($status == 'Failed') {
            return 'Invoice is not paid due to ' . $error;
        } else if ($status == 'Expired') {
            return $error;
        }
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
            'returnUrl' => url('/successURL') , 
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

}
