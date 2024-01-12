<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Banquemisr;
class TestController extends Controller
{
  public function index()
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
          'name' => 'The Company Co',
          'url' => 'https://www.merchant-site.com',
          'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/21/Verlagsgruppe_Random_House_Logo_2016.png',
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
        'amount' => '123.60',
        'currency' => 'SAR',
        'description' => 'This is the order description',
        'id' => 'ORDE798798R-4142773a-ac2e1111',
      ),
      'customer' => 
      array (
        'email' => 'peteMorris@mail.us.com',
        'firstName' => 'John',
        'lastName' => 'Doe',
        'mobilePhone' => '+1 5557891230',
        'phone' => '+1 1234567890',
      ),
    );

    curl_setopt($curl, CURLOPT_URL, 'https://banquemisr.gateway.mastercard.com/api/rest/version/72/merchant/'.$merchantID.'/session');
    curl_setopt($curl, CURLOPT_USERPWD, 'merchant.' . $merchantID . ':' . $merchantPassword . '');
    // curl_setopt($curl, CURLOPT_USERPWD, 'merchant.' . $merchantID . ':' . $merchantPassword . '');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($curl);
    curl_close($curl);
    $jsonData = json_decode($response);
    $sessionID  = $jsonData->session->id; 
    return view('test' , compact('sessionID') );
    
  }

  public function index2()
  {

    // f21a82080dbc41a5
    $merchantID = 'TESTTHEGATE_ACAD' ;
    $merchantPassword = '28c84d5aa95f3c8149cee8aa68173240' ;

    $curl = curl_init();
    $data = [
        'apiOperation' =>   'CAPTURE' , 
        'transaction' => [
          'amount' => '123.60' ,
          'currency' => 'SAR'
        ], 
    ];
    curl_setopt($curl, CURLOPT_URL, 'https://banquemisr.gateway.mastercard.com/api/rest/version/77/merchant/'.$merchantID.'/order/ORDER-4142773a-ac2e1111');
    curl_setopt($curl, CURLOPT_USERPWD, 'merchant.' . $merchantID . ':' . $merchantPassword . '');
    // curl_setopt($curl, CURLOPT_USERPWD, 'merchant.' . $merchantID . ':' . $merchantPassword . '');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_POST, true);
    // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($curl);
    curl_close($curl);
    $jsonData = json_decode($response);

    dd($jsonData);



  }
}