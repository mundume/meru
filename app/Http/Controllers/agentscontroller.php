<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\{Parcel,AgentCourier};
use Carbon\Carbon;

class agentscontroller extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function check_if_agent_booking() {
        if(Auth::check() && Auth::user()->hasRole('booking')) {
            return true;
        }
        return false;
    }
    public function index() {
        if($this->check_if_agent_booking() == false) return redirect()->back();
        $user = auth()->user();
        $agent = AgentCourier::where('user_id', $user->id)->first();
        $parcels = Parcel::orderBy('id', 'desc')->where([['progress', 1], ['destination_office', $agent->dropoff_id]]);
        $bookings = $user->agent_booking;
        $books = $user->agent_booking()->whereDate('booking_users.created_at', Carbon::today())->get();
        // $parcels = auth()->user()->agent_parcels()->whereDate('parcel_users.created_at', Carbon::today())->get();
        $routes = $user->agent_routes;
        return view('agents.index', compact('parcels', 'bookings', 'routes', 'books'));
    }
    public function bookings(Request $request) {
        if($this->check_if_agent_booking() == false) return redirect()->back();
        $user = auth()->user();
        if($request->created_at) {
            $bookings = $user->agent_booking()->whereDate('booking_users.created_at', $request->created_at)->get();
        } else {
            $bookings = $user->agent_booking;
        }
        return view('agents.bookings', compact('bookings'));
    }
    public function filter_bookings(Request $request) {
        return redirect()->route('agent.bookings', ['created_at' => $request->date]);
    }
}
