<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\{Fleet,Parcel};
use Carbon\Carbon;

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
        $fleets = Fleet::where([['user_id', $filter_user], ['suspend', false]])->get();
        $parcels = auth()->user()->agent_parcels()->whereDate('parcel_users.created_at', Carbon::today())->get();
        return view('parcels.add_parcel', compact('fleets', 'parcels'));
    }
    public function post_parcel(Request $request) {

    }
}
