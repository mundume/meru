<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\{AgentCourier,Parcel,Fleet};
use Carbon\Carbon;

class courierscontroller extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function check_if_agent_courier() {
        if(Auth::check() && Auth::user()->hasRole('courier')) {
            return true;
        }
        return false;
    }
    public function index() {
        if($this->check_if_agent_courier() == false) return redirect()->back();
        $user = auth()->user();
        $agent = AgentCourier::where('user_id', $user->id)->first();
        $count_parcels = Parcel::orderBy('id', 'desc')->where([['progress', 1], ['destination', $agent->dropoff_id]])->count();
        $fleets = Fleet::where('suspend', false)->get();
        $parcels = auth()->user()->agent_parcels()->whereDate('parcel_users.created_at', Carbon::yesterday())->get();
        return view('courier.index', compact('parcels', 'fleets', 'count_parcels'));
    }
}
