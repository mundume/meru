<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\{Provider,Dropoff};

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
    }
    public function add_dropoff(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back(); 
    }
    public function add_coordinate(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back(); 
    }
    public function delete_charge($id) {
        if($this->check_if_admin() == false) return redirect()->back(); 
    }
    public function add_charge(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back(); 
    }
    public function edit_charge(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back(); 
    }
    public function preview() {
        if($this->check_if_admin() == false) return redirect()->back(); 
        return view('settings.preview');
    }
}
