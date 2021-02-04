<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Route,Booking,Parcel,Payment,Calendarial};
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use App\Http\Controllers\pesacontroller;
use App\Http\Controllers\smscontroller;
use Session;
use Auth;

class pagescontroller extends Controller
{
public function independent() {
    $uni = Route::distinct()->where([['suspend',0], ['admin_suspend', 0]])
            ->orderBy('departure','ASC')->orderBy('destination','ASC')->get();
    $routes = Route::where([['suspend',0], ['admin_suspend', 0]])->inRandomOrder()->paginate(6);
    $total_booking = Booking::where('is_paid', true)->count();
    $today_booking = Booking::where('is_paid', true)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->count();
    $total_parcel = Parcel::where('is_paid', true)->count();
    $today_parcel = Parcel::where('is_paid', true)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->count();
    return view('independent', compact('uni', 'routes', 'total_booking', 'today_booking', 'total_parcel', 'today_parcel'));
}
public function search(Request $request) {
    $uni = Route::distinct()->where([['suspend',0], ['admin_suspend', 0]])
            ->orderBy('departure','ASC')->orderBy('destination','ASC')->get();
    $routes = Route::where('departure', 'LIKE', "%".$request->departure."%")
                ->where('destination', 'LIKE', "%".$request->destination."%")                
                ->where('seaters', 'LIKE', "%".$request->seaters."%")
                ->where([['suspend',0], ['admin_suspend', 0]])
                ->get();
    return view('pages.search', compact('routes', 'uni'));
}
public function show_route($id) {  
    $route = Route::find(base64_decode($id));
    if($route->suspend == false && $route->admin_suspend == false) {
        return view('dashboard.routes.show_route', compact('route'));
    }  else {
        if(Auth::check() && Auth::user()) {
            return view('dashboard.routes.show_route', compact('route'));
        } else {
            return redirect()->route('independent');
        }
    }
}
public function booking_step_one(Request $request, $route_id) {
    $this->validate($request, [
        'fullname' => 'required',
        'mobile' => 'required|digits:10',
        'pick_up' => 'required',
        'id_no' => 'required'
    ]);
    $route = Route::find(base64_decode($route_id));
    $ticket_no = mt_rand(1000, 9999);
    $token = hash('sha256', Str::random(20));
    $contact = '254'.substr($request->mobile,-9);
    DB::transaction(function() use($request, $ticket_no, $token, $contact, $route) {
        $booking = [
            'user_id' => $route->user_id,
            'group' => $route->group,
            'seaters' => $route->seaters,
            'amount' => 0,
            'fullname' => $request->fullname,
            'id_no' => $request->id_no,
            'pick_up' => $request->pick_up,
            'mobile' => $contact,
            'ticket_no' => $ticket_no,
            'departure' => $route->departure,
            'destination' => $route->destination,
            'CheckoutRequestID' => 0,
            'ticket_token' => $token,
            'payment_method' => "mpesa",
            'fleet_unique' => $route->fleet_unique
        ];
        $payment = [
            'user_id' => $route->user_id,
            'ResultCode' => 0,
            'ResultDesc' => 0,
            'MerchantRequestID' => 0,
            'CheckoutRequestID' => 0,
            'mpesaReceiptNumber' => 0,
            'ticket_no' => $ticket_no,
            'amount' => 0,
            'phoneNumber' => $contact,
            'TransactionDate' => Carbon::now()
        ];
        Booking::create($booking);
        Payment::create($payment);
    });
    return redirect('/route/booking/complete/'.$ticket_no);
}
public function complete_booking($ticket_no) {
    $book = Booking::where('ticket_no', $ticket_no)->first();
    if(!$book)return redirect()->back();
    $route = Route::where('fleet_unique', $book->fleet_unique)->first();
    return view('pages.complete_booking', compact('book','route'));
}
public function post_complete_booking(Request $request) {
    $book = Booking::where('ticket_no', $request->ticket_no)->first();
    if($book->is_paid == 1) return redirect('/route/booking/status/'.$book->ticket_token);
    $this->validate($request, [
        'travel_date' => 'required',
        'ticket_no' => 'required',
        'time' => 'required',
        'seat_no' => 'required'
    ]);
    $exist = Calendarial::where([['fleet_unique', $book->fleet_unique], ['date', $request->travel_date]])->first();
    if($exist) {
        if($exist->lock == true) {
            Session::flash('info', 'Oops, fleet not available on that date. Kindly change date or book another.');
            return redirect()->back();
        } else {
            $amount = $exist->amount;
        }
    } else {
        $route = Route::where('fleet_unique', $book->fleet_unique)->first();
        $amount = $route->amount;
    }
    $contact = '254'.substr($request->mobile,-9);
    $stk = new pesacontroller;
    $result = $stk->stk_push(
        $request->ticket_no,
        $amount,
        $contact,
        route('payment.callback'),
        'BOOKING PAYMENT'
    );
    if($result['ResponseCode'] == 0) {
        DB::transaction(function() use($amount, $result, $request) {
            Booking::where('ticket_no', $request->ticket_no)->update([
                'CheckoutRequestID' => $result->CheckoutRequestID,
                'amount' => $amount,
                'time' => $request->time,
                'travel_date' => $request->travel_date,
                'seat_no' => $request->seat_no
            ]);
            Payment::where('ticket_no', $request->ticket_no)->update([
                'MerchantRequestID' => $result->MerchantRequestID,
                'CheckoutRequestID' => $result->CheckoutRequestID,
            ]);
        });
        $message = "Ticket Status\r\nhttp://127.0.0.1:8000/route/booking/status/".$book->ticket_no;
        $sms = new smscontroller;
        $sms->send_sms($contact, $message);
        Session::flash('success', 'Ticket generated successfully.');
        return redirect('/route/booking/status/'.$book->ticket_no);
    } else {
        Booking::where('ticket_no', $request->ticket_no)->update([
            'amount' => $amount,
            'time' => $request->time,
            'travel_date' => $request->travel_date,
            'seat_no' => $request->seat_no
        ]);
        $message = "Ticket Status\r\nhttp://127.0.0.1:8000/route/booking/status/".$book->ticket_no;
        $sms = new smscontroller;
        $sms->send_sms($contact, $message);
        Session::flash('success', 'Ticket generated successfully.');
        return redirect('/route/booking/status/'.$book->ticket_no);
    }
}
public function ticket_status($ticket_no) {
    $books = Booking::where('ticket_no', $ticket_no)->first();
    if(!$books) return redirect()->route('independent'); 
    $stat = Booking::orderBy('id', 'desc')->where('is_paid', 1);
    return view('pages.booking_status', compact('books', 'stat'));
}
public function booked_seats(Request $request) {
    $books = Booking::where([
                ['is_paid', 1],
                ['suspended', 0],
                ['dispatched', 0],
                ['seaters', $request->seaters],
                ['departure', $request->departure],
                ['destination', $request->destination]
                ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->get();
    $data = [];
    foreach($books as $book) {
        $seats = $book->seat_no;
        array_push($data, $seats);
    }
    return json_encode($data);
}
public function modal_booked(Request $request) {
    $ders = Booking::where([
        ['user_id', $request->user_id],
        ['seaters', $request->seaters],
        ['is_paid', 1],
        ['dispatched', 0],
        ['travel_date', $request->date],
        ['time', '=', $request->time]
    ])->get();
    $data = [];
    foreach($ders as $der) {
        $seat = $der->seat_no;
        array_push($data, $seat);
    }
    return json_encode($data);
}
public function booked_calendarial(Request $request) {
    $exist = Calendarial::where([['fleet_unique', $request->fleet_unique], ['date', $request->date]])->first();
    if($exist) {
        if($exist->lock == true) {
            $amount = 'X_L01';
        } else {
            $amount = $exist->amount;
        }
    } else {
        $route = Route::where('fleet_unique', $request->fleet_unique)->first();
        $amount = $route->amount;
    }
    return json_encode($amount);
}
public function check_status(Request $request) {
    $book = Booking::where('ticket_no', $request->ticket_no)->select('is_paid')->first();
    return json_encode($book);
}
}
