<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pesacontroller extends Controller
{
    public function prompt_push($identifier, $amount, $contact,$callback,$remarks) {
        $response = [
            'ResponseCode' => 1
        ];
        return $response;
    }
    public function stk_callback() {
        $callbackJSONData = file_get_contents('php://input');
        $callbackData = json_decode($callbackJSONData);
        if($callbackData->Body->stkCallback->ResultCode == 0) {
            //on success payment on booking push update to header app
        }
    }
    public function paybill_validation() {

    }
    public function paybill_confirmation() {
        $callbackJSONData = file_get_contents('php://input');
        $callbackData = json_decode($callbackJSONData);
        //on success booking update push update to header app
    }
}
