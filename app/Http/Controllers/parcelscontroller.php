<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\{Fleet,Parcel,Provider,Dropoff,Charge,Account,ParcelUser,Cec,Payment,Message,AgentCourier};
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;
use App\Http\Controllers\smscontroller;
use Session;
use PDF;
use App\Jobs\SendSms;

class parcelscontroller extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function check_if_admin() {
        if(Auth::check() && Auth::user()->hasRole('admin')) {
            return true;
        }
        return false;
    }
    public function index() {
        $filter_user = app_filterAgent();
        $user = auth()->user();
        $fleets = Fleet::where([['user_id', $filter_user], ['suspend', false]])->get();
        $parcels = auth()->user()->agent_parcels()->whereDate('parcel_users.created_at', Carbon::today())->get();
        $prov = Provider::where('user_id', $user->id)->first();
        $dest = Dropoff::where('provider_id', $filter_user)->get();
        return view('parcels.add_parcel', compact('fleets', 'parcels', 'dest'));
    }
    public function post_parcel(Request $request) {
        $validator = Validator::make($request->all(), [
            'sender_name' => 'required',
            'sender_mobile' => 'required|digits:10',
            'parcel_description' => 'required',
            'receiver_name' => 'required',
            'receiver_mobile' => 'required|digits:10',
            'id_no' => 'required|min:6',
            'destination' => 'required',
            'size' => 'required', 
            'service_provider_amount' => 'required',
            'is_paid' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'coo')->withInput();
        }

        $drop = Dropoff::where('id', $request->destination)->first();
        $cec = Dropoff::where('office_name', $drop->office_name)->first();

        $filter_user = app_filterAgent();
        $prov = Provider::where('user_id', $filter_user)->first();
        $provider = [$prov->id, $prov->c_name];
        $url = Str::random(10);
        $parcel_no = 'PA'.mt_rand(1000, 9999);
        $account = Account::where('user_id', auth()->user())->first();
        $contact = '254'.substr($request->send_mobile, -9);
        DB::transaction(function() use($filter_user,$request,$contact,$url,$parcel_no,$provider,$cec) {
            $parcel_data = [
                'user_id' => $filter_user,
                'sender_name' => $request->sender_name,
                'sender_mobile' => $request->sender_mobile,
                'parcel_description' => $request->parcel_description,
                'receiver_name' => $request->receiver_name,
                'receiver_mobile' => $request->receiver_mobile,
                'id_no' => $request->id_no,
                'provider' => $provider,
                'destination' => $request->destination,
                'destination_office' => $cec->id,
                'size' => $request->size,
                'service_provider_amount' => $request->service_provider_amount,
                'url' => $url,
                'parcel_no' => $parcel_no,
                'is_paid' => $request->is_paid
            ];
            $payment = [
                'user_id' => $filter_user,
                'ResultCode' => 0,
                'ResultDesc' => 'Parcel Payment',
                'MerchantRequestID' => 0,
                'CheckoutRequestID' => 0,
                'mpesaReceiptNumber' => 0,
                'ticket_no' => $parcel_no,
                'amount' => $request->service_provider_amount,
                'phoneNumber' => $request->sender_mobile,
                'TransactionDate' => Carbon::now()
            ];
            $parcel = Parcel::create($parcel_data);
            Payment::create($payment);
            $creator = [
                'parcel_id' => $parcel->id,
                'user_id' => auth()->user()->id
            ];
            ParcelUser::create($creator);

            $message = Message::where('name', 'PARCEL_SENDER')->first()->body;
            $message = str_replace('%parcel_no%', $parcel_no, $message);
            $message = str_replace('%break%', "\r\n", $message);
            $message = str_replace('%link%', config('app.url'), $message);

            $sms = new smscontroller;
            $sms->send_sms($contact, $message);
        });
        Session::flash('success', 'Parcel added');
        return redirect()->back();
    }
    public function dropoffs_sub_category(Request $request) {
        $data = Charge::where('dropoff_id', $request->cat_id)->get();
        return json_encode($data);
    }
    public function bun_sub_category(Request $request) {
        $data = Charge::where('id', $request->cat_id)->get();
        return json_encode($data);
    }
    public function update_progress($id) {
        $parc = Parcel::with('dropoff')->find($id);
        $path = public_path('pdfs/');               
        $der = $path.$parc->parcel_no.'-'.date('Y-m-d-H-i').'.pdf';
        $pdf = PDF::loadView('prints.parcel_ticket', compact('parc'))->setPaper('a7')->setWarnings(false)->save($der);        
        DB::transaction(function() use($id,$der,$parc) {
            $parcel = Parcel::where('id', $id)->update([
                'progress' => true
            ]);
            $cec = Cec::create([
                'path' => $der,
                'fleet_id' => $parc->parcel_no
            ]);
        });
        Session::flash('success', 'Progess updated successfully');
        return redirect()->back();
    }
    public function parcel_assign_fleet(Request $request, $parcel_no) {
        $check = Parcel::where('parcel_no', $parcel_no)->first();
        $parcel_user = ParcelUser::where('parcel_id', $check->id)->first();
        if($parcel_user->user_id != auth()->user()->id) {
            Session::flash('error', 'Oops, you are not allowed to perform operation.');
            return redirect()->back();
        }
        $parcel = Parcel::where('parcel_no', $parcel_no)->update([
            'fleet_id' => $request->fleet_id
        ]);

        // $message = Message::where('name', 'PARCEL_RECEIVER')->first()->body;
        // $message = str_replace('%parcel_no%', $parcel_no, $message);
        // $message = str_replace('%name%', $parcel->receiver_name, $message);
        // $message = str_replace('%break%', "\r\n", $message);
        // $message = str_replace('%link%', config('app.url'), $message);

        // $sms = new smscontroller;
        // $sms->send_sms($parcel->receiver_mobile, $message);

        Session::flash('success', 'Parcel assigned to fleet.');
        return redirect()->back();
    }
    public function picked($id) {
        $path = public_path('pdfs/');
        $parc = Parcel::find($id);               
        $der = $path.'Receipt-'.$parc->parcel_no.'.pdf';
        $pdf = PDF::loadView('prints.parcel_receipt', compact('parc'))->setPaper('a7')->setWarnings(false)->save($der);        
        DB::transaction(function() use($id,$der,$parc) {            
            $parc->update([
                'picked' => true,
                'is_paid' => true
            ]);
            Cec::create([
                'path' => $der,
                'fleet_id' => $parc->parcel_no,
                'is_receipt' => true
            ]);
        });
        Session::flash('success', 'Parcel marked as received');
        return redirect()->back();
    }
    public function parcel_sms(Request $request, $id) {
        $parcel = Parcel::find($id);
        $dispatch = ['mobile' => $parcel->receiver_mobile, 'message' => $request->message];
        SendSms::dispatch($dispatch)->delay(Carbon::now()->addSeconds(2));
        Session::flash('success', 'Message sent successfully.');
        return redirect()->back();
    }
    public function agent_bulk_sms(Request $request) {
        $this->validate($request, ['type' => 'required', 'date' => 'required']);
        if($request->date != Carbon::yesterday()->format('Y-m-d')) {
            Session::flash('error', 'Oops, kindly select correct date.');
            return redirect()->back();
        }
        $user = Auth::user()->id;
        $agent = AgentCourier::where('user_id', $user)->first();
        $parcels = Parcel::whereDate('created_at', Carbon::yesterday())->where([['picked', false],['progress', true],['destination_office', $agent->dropoff_id]])->get();
        if($parcels->count() <= 0) {
            Session::flash('error', 'Oops, parcels doesn\'t exists.');
            return redirect()->back();
        }
        foreach($parcels as $parcel) {
            $office = Dropoff::find($parcel->destination_office)->office_name;
            $message = Message::where('name', 'COLLECT_PARCEL')->first()->body;
            $message = str_replace('%link%', config('app.url'), $message);
            $message = str_replace('%mobile%', '0746245461', $message);
            $message = str_replace('%break%', "\r\n", $message);
            $message = str_replace('%office%', $office, $message);
            $dispatch = ['mobile' => $parcel->receiver_mobile, 'message' => $message];
            SendSms::dispatch($dispatch)->delay(Carbon::now()->addSeconds(2));
        }
        Session::flash('success', 'Message sent successfully.');
        return redirect()->back();
    }
    public function print_parcel($parcel_no) {
        $print = Cec::orderBy('id','desc')->where('fleet_id', $parcel_no)->first();
        if($print) {
            return response()->download($print->path);
        } 
        Session::flash('info', 'Oops, failed kindly try again later.');
        return redirect()->back();
    }
    public function print_dropoff(Request $request) {
        $user = auth()->user();
        $der = app_filterAgent();
        $drop = Dropoff::find($request->drop);
        $parcs = Parcel::where([['user_id', $der], ['destination', $request->drop], ['is_paid', true]])
                ->whereDate('created_at', '>=', $request->start_d)
                ->whereDate('created_at', '<=', $request->end_d)
                ->get();
        if($parcs->count() <= 0) {
            Session::flash('error', 'Oops, no data exist.');
            return redirect()->back();
        }
        $pdf = PDF::loadView('prints.all_parcel', compact('parcs', 'user', 'drop'))->setPaper('a4');
        $bun = mt_rand(1000, 9999);
        return $pdf->download('parcels-'.$bun.'.pdf');
    }
    public function print_receipt($parcel_no) {
        $print = Cec::orderBy('id','desc')->where([['is_receipt', true], ['fleet_id', $parcel_no]])->first();
        if($print) {
            return response()->download($print->path);
        } 
        Session::flash('info', 'Oops, failed kindly try again later.');
        return redirect()->back();
    }
}
