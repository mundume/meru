<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\{Fleet,Parcel,Provider,Dropoff,Charge,Account,ParcelUser,Cec};
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;
use App\Http\Controllers\smscontroller;
use Session;
use PDF;

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
            'payment_method' => 'required',
            'is_paid' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'coo')->withInput();
        }
        $filter_user = app_filterAgent();
        $prov = Provider::where('user_id', $filter_user)->first();
        $provider = [$prov->id, $prov->c_name];
        $url = Str::random(10);
        $parcel_no = 'PA'.mt_rand(1000, 9999);
        $account = Account::where('user_id', auth()->user())->first();
        $contact = '254'.substr($request->send_mobile, -9);
        if($request->payment_method == 'mpesa') {

        } else {
            DB::transaction(function() use($filter_user,$request,$contact,$url,$parcel_no,$provider) {
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
                    'size' => $request->size,
                    'service_provider_amount' => $request->service_provider_amount,
                    'url' => $url,
                    'parcel_no' => $parcel_no,
                    'payment_method' => $request->payment_method,
                    'is_paid' => $request->is_paid
                ];
                $parcel = Parcel::create($parcel_data);
                $creator = [
                    'parcel_id' => $parcel->id,
                    'user_id' => auth()->user()->id
                ];
                ParcelUser::create($creator);
                $message = "Parcel Number ". $parcel_no."\r\nRegards\r\n".Auth::user()->c_name." Team";
                $sms = new smscontroller;
                $sms->send_sms($contact, $message);
            });
            Session::flash('success', 'Parcel added');
            return redirect()->back();
        }
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
        $parcel = Parcel::where('parcel_no', $parcel_no)->update([
            'fleet_id' => $request->fleet_id
        ]);
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
    public function parcel_sms($id) {
        
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
