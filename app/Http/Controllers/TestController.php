<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Banquemisr;
use Vimeo;
use Http;
use Twilio\Rest\Client;

class TestController extends Controller
{
  public function index()
  {


    $twilioSid = env('TWILIO_AUTH_SID');
    $twilioToken = env('1bd371d576aefb43ed839ce8da034cbe');
    $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_FROM');
        $recipientNumber = 'whatsapp:+201014340346'; // Replace with the recipient's phone number in WhatsApp format (e.g., "whatsapp:+1234567890")
        $message = "برجاء سداد القسط المستحق الدفع بتاريخ *10/4/2024* بقيمه *500 ريال* الخاص بى *دور التصميم و البرمجه* ";

        $twilio = new Client($twilioSid, $twilioToken);

        try {
          $twilio->messages->create(
            $recipientNumber,
            [
              "from" => 'whatsapp:'.$twilioWhatsAppNumber,
              "body" => $message,
            ]
          );

          return response()->json(['message' => 'WhatsApp message sent successfully']);
        } catch (\Exception $e) {
          return response()->json(['error' => $e->getMessage()], 500);
        }



        dd('gg');

        $users = User::permission(['notifications.transactions.new'])->get();

        dd($users);


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