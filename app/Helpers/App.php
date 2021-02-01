<?php
use Carbon\Carbon;
use App\Models\{AgentUser};
use App\Http\Controllers\smscontroller;

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