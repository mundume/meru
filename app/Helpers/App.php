<?php
use Carbon\Carbon;
use App\Models\{AgentUser};
use App\Http\Controllers\smscontroller;
use GuzzleHttp\Client;

function app_filterDate($date, $time) {
    if($date == null && $time == null) {
        $data = [
            'date' => Carbon::now()->format('Y-m-d'),
            'time' => Carbon::now()->format('h:iA')
        ];
        return $data;
    } else {
        $data = [
            'date' => $date,
            'time' => $time
        ];
        return $data;
    }
}
function app_filterAgent() {
    $id = auth()->user()->id;
    $agents = AgentUser::get(['user_id', 'company_id']);
    $data = [];
    foreach($agents as $agent) {
        array_push($data, $agent->user_id);
    }
    if(in_array($id, $data)) {
        $cec = AgentUser::where('user_id', $id)->first();
        $der = $cec->company_id;
        return $der;
    } else {
        $der = $id;
        return $der;
    }
}
function app_existsAgent() {
    $id = auth()->user()->id;
    $agents = AgentUser::get(['user_id']);
    $data = [];
    foreach($agents as $agent) {
        array_push($data, $agent->user_id);
    }
    if(in_array($id, $data)) {
        $der = 1;
        return $der;
    } else {
        $der = 0;
        return $der;
    }
}
function app_ErrorOne() {
    $message = "Critical Error Notification.\r\nSubsidiary failed to book a seat.\r\nERROR_01.";
    $contact = "254799770833";
    $sms = new smscontroller;
    $sms->send_sms($contact, $message);
}
function artists_LipaMpesaPassword() {
    $BusinessShortCode = config("app.business_code");
    $LipaNaMpesaPasskey = config("app.pass_key");
    $timestamp = '20' . date("ymdhis");
    return base64_encode($BusinessShortCode . $LipaNaMpesaPasskey . $timestamp);
}
function artists_LiveToken() {
    $consumer_key = config("app.mpesa_consumer_key");
    $consumer_secret = config("app.mpesa_consumer_secret");
    if (!isset($consumer_key) || !isset($consumer_secret)) {
        die("please declare the consumer key and consumer secret as defined in the documentation");
    }
    $client = new Client();
    $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
    $response = $client->request('get', 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials', [
        'verify' => false,
        'headers' => [
            'Authorization' => 'Basic ' . $credentials,
        ]
    ]);
    $obj = json_decode((string)$response->getBody());
    $token = $obj->access_token;
    return $token;
}