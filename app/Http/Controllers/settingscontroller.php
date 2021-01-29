<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\{Provider,Dropoff,Charge};
use Session;
use DB;
use Illuminate\Support\Arr;

class settingscontroller extends Controller
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
        if($this->check_if_admin() == false) return redirect()->back();
        $id = auth()->user()->id;
        $prov = Provider::where('user_id', $id)->first();
        $drops = Dropoff::where('provider_id', $prov->id)->with('charge')->get();
        return view('settings.index', compact('prov', 'drops'));
    }
    public function add_provider(Request $request) {
       if($this->check_if_admin() == false) return redirect()->back(); 
       $id = auth()->user()->id;
        $exist = Provider::where('user_id', $id)->first();
        if($exist) {
            Session::flash('error', 'Oops, you cant manage more than one courier service');
            return redirect()->back();
        }
        $cou = new Provider;
        $cou->user_id = $id;
        $cou->c_name = $request->c_name;
        $cou->save();
        Session::flash('success', 'Courier service added successfully');
        return redirect()->back();
    }
    public function add_dropoff(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back(); 
        $id = auth()->user()->id;
        $prov = Provider::where('user_id', $id)->first();
        $office_route = $request->from . "~" . $request->to;
        $drop = new Dropoff;
        $drop->provider_id = $prov->id;
        $drop->office_route = $office_route;
        $drop->office_name = $request->office_name;
        $drop->save();
        Session::flash('success', 'Dropoff added.');
        return redirect()->back();
    }
    public function add_coordinate(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back(); 
    }
    public function delete_charge($id) {
        if($this->check_if_admin() == false) return redirect()->back(); 
    }
    public function add_charge(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back(); 
        try {
            foreach($request->charge as $key => $value) {
                $charge = new Charge;
                $charge->dropoff_id = $request->dropoff_id;
                $charge->name = $value['name'];
                $charge->price = $value['price'];
                $charge->save();
            }
            Session::flash('success', 'Added successfully');
            return redirect()->back();
        } catch(\Exception $e) {
            Session::flash('error', 'Something wrong form kindly confirm your field');
            return redirect()->back();
        }
    }
    public function edit_charge(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back(); 
        $name = [];
        $price = [];
        foreach($request->charge as $cec) {
            $dat = $cec['name'];
            array_push($name, $dat);
        }
        foreach($request->charge as $ce) {
            $da = $ce['price'];
            array_push($price, $da);
        }
        $name = Arr::flatten($name);
        $price = Arr::flatten($price);
        $data = array_map(null, $name, $price);
        $charge = Charge::where('dropoff_id', $request->dropoff_id)->get();

        DB::transaction(function() use($charge, $data, $request) {            
            foreach($charge as $cha) {
                $cha->delete();
            }
            foreach($data as $key => $value) {
                if($value[0] != null && $value[1] != null) {
                    $charge = new Charge;
                    $charge->dropoff_id = $request->dropoff_id;
                    $charge->name = $value[0];
                    $charge->price = $value[1];
                    $charge->save();
                }
            }
        });
        Session::flash('success', 'Update successfully done.');
        return redirect()->back();
    }
    public function preview() {
        if($this->check_if_admin() == false) return redirect()->back(); 
        $filter_user = app_filterAgent();
        $prov = Provider::where('user_id', $filter_user)->with('dropoff')->get();
        $charge = [];
        foreach($prov as $dropoff) {
            foreach($dropoff->dropoff as $data) {
                $chas = Charge::where('dropoff_id', $data->id)->with('dropoff')->get();
                foreach($chas as $cha) {
                    array_push($charge, $cha);
                }
            }
        }
        return view('settings.preview', compact('prov', 'charge'));
    }
}
