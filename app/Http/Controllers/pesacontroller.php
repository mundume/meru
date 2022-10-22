<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Jobs\SendSms;
use GuzzleHttp\Client;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\{Payment,Booking};
use Illuminate\Support\Facades\Log;

class pesacontroller extends Controller
{
    public function prompt_push($identifier, $amount, $contact,$callback,$remarks) {
        $token = artists_LiveToken();
        $client = new Client;
        $res = $client->request('post', config('services.stk_push_url'), [
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
        Log::critical($callbackJSONData);
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
            $user = Booking::where('CheckoutRequestID', $checkoutRequestID)->first();
            $user->is_paid = 1;
            $user->save();

            $message = Message::where('name', 'PAID_STK')->first()->body;
            $message = str_replace('%ticket_no%', $user->ticket_no, $message);
            $message = str_replace('%seat_no%', $user->seat_no, $message);
            $message = str_replace('%name%', $user->fullname, $message);
            $message = str_replace('%seaters%', $user->seaters, $message);
            $message = str_replace('%break%', "\r\n", $message);
            // $dispatch = ['mobile' => $contact, 'message' => $message];
            SendSms::dispatch($contact,$message)->delay(Carbon::now()->addSeconds(3));
            
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
