<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\{Payment,Booking};

class pesacontroller extends Controller
{
    public function prompt_push($identifier, $amount, $contact,$callback,$remarks) {
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $token = artists_LiveToken();
        $client = new Client;
        $res = $client->request('post', $url, [
            'verify' => false,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'BusinessShortCode' => config("app.business_code"),
                'Password' => artists_LipaMpesaPassword(),
                'Timestamp' => '20' . date("ymdhis"),
                'TransactionType' => config("app.mpesa_type"),
                'Amount' => $amount,
                'PartyA' => $contact,
                'PartyB' => config("app.business_code"),
                'PhoneNumber' => $contact,
                'CallBackURL' => $callback,
                'AccountReference' => $identifier,
                'TransactionDesc' => $remarks,
            ])
        ]);
        $response = json_decode((string)$res->getBody());
        return $response;
    }
    public function stk_callback() {
        $callbackJSONData = file_get_contents('php://input');
        $callbackData = json_decode($callbackJSONData);
        if($callbackData->Body->stkCallback->ResultCode == 0) {
            //on success payment on booking push update to header app
            $resultCode = $callbackData->Body->stkCallback->ResultCode;
            $resultDesc = $callbackData->Body->stkCallback->ResultDesc;
            $merchantRequestID = $callbackData->Body->stkCallback->MerchantRequestID;
            $checkoutRequestID = $callbackData->Body->stkCallback->CheckoutRequestID;
            $amount = $callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Value;
            $mpesaReceiptNumber = $callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
            $date = $callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
            $phoneNumber = $callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;

            Payment::where('CheckoutRequestID', $checkoutRequestID)->update([
                'ResultCode' => $resultCode,
                'ResultDesc' => $resultDesc,
                'MerchantRequestID' => $merchantRequestID,
                'mpesaReceiptNumber' => $mpesaReceiptNumber,
                'amount' => $amount
            ]);
            Booking::where('CheckoutRequestID', $checkoutRequestID)->update([
                'is_paid' => 1
            ]);
        } else {
            $resultCode = $callbackData->Body->stkCallback->ResultCode;
            $resultDesc = $callbackData->Body->stkCallback->ResultDesc;
            $merchantRequestID = $callbackData->Body->stkCallback->MerchantRequestID;
            $checkoutRequestID = $callbackData->Body->stkCallback->CheckoutRequestID;

            Payment::where('CheckoutRequestID', $checkoutRequestID)->update([
                'ResultCode' => $resultCode,
                'ResultDesc' => $resultDesc,
                'MerchantRequestID' => $merchantRequestID,
                'mpesaReceiptNumber' => 0
            ]);
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
