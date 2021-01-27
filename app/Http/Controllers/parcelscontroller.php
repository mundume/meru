<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
        if($this->check_if_admin() == false) return redirect()->back();
        return view('parcels.add_parcel');
    }
}
