<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class courierscontroller extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function check_if_agent_courier() {
        if(Auth::check() && Auth::user()->hasRole('booking')) {
            return true;
        }
        return false;
    }
    public function index() {
        if($this->check_if_agent_courier() == false) return redirect()->back();
    }
}
