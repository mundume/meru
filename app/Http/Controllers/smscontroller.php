<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;

class smscontroller extends Controller
{
    public function send_sms($contact, $message) {
        $apiKey = config('services.africastalking_key');
        $username = config('services.africastalking_secret');
        $env = config('services.africastalking_env');
        if($env == "prod") {
            $AT = new AfricasTalking($username, $apiKey);
            $sms = $AT->sms();
            $result = $sms->send([
                'to'      => $contact,
                'message' => $message
            ]);
        }
    }
}
