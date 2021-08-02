<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Route,Booking,Payment,User};
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use DB;

class apiscontroller extends Controller
{
    public function __construct() {
        $this->booked = config('services.xwift_url').config('services.xwift_api_key').'/books';
        $this->update_route = config('services.xwift_url').config('services.xwift_api_key').'/update_route';
        $this->create_calend = config('services.xwift_url').config('services.xwift_api_key').'/create_calend';
        $this->update_calend = config('services.xwift_url').config('services.xwift_api_key').'/update_calend';
        $this->delete_calend = config('services.xwift_url').config('services.xwift_api_key').'/delete_calend';
        $this->head_dispatch_url = config('services.xwift_url').config('services.xwift_api_key').'/dispatches';
        $this->head_book_update = config('services.xwift_url').config('services.xwift_api_key').'/subsidiary_books';
    }
    public function check_booked() {
        $client = new Client;
        $der = $client->get($this->booked);
        $response = json_decode($der->getBody(), true);
        foreach($response as $res => $value) {
            $routes = Route::get();
            foreach($routes as $route) {
                if($route->fleet_unique == $value['fleet_unique']) {                    
                    try {
                        $book = [
                            'user_id' => 1,
                            'CheckoutRequestID' => null,
                            'group' => User::first()->c_name,
                            'seaters' => $value['seaters'],
                            'amount' => $value['amount'],
                            'fullname' => $value['fullname'],
                            'id_no' => $value['idnumber'],
                            'pick_up' => $value['pickUp'],
                            'mobile' => $value['phonenumber'],
                            'time' => $value['time'],
                            'travel_date' => $value['travel_date'],
                            'ticket_no' => $value['ticket_no'],
                            'departure' => $value['departure'],
                            'destination' => $value['destination'],
                            'ticket_token' => $value['ticketToken'],
                            'seat_no' => $value['seat_no'],
                            'is_paid' => $value['status'],
                            'payment_method' => 'mpesa',
                            'fleet_unique' => $value['fleet_unique']
                        ];
                        $payment = [
                            'user_id' => 0,
                            'ResultCode' => 0,
                            'ResultDesc' => 'Xwift Ticket',
                            'MerchantRequestID' => 0,
                            'CheckoutRequestID' => 0,
                            'mpesaReceiptNumber' => 0,
                            'ticket_no' => $value['ticket_no'],
                            'amount' => $value['amount'],
                            'phoneNumber' => $value['phonenumber'],
                            'TransactionDate' => Carbon::now()
                        ];
                        $exists = Booking::where('ticket_no', $value['ticket_no'])->first();
                        if(!$exists) {
                            DB::transaction(function() use($book,$payment) {
                                Booking::create($book);
                                Payment::create($payment);
                            });
                        }
                    } catch (\Exception $e) {
                        $level_one = app_ErrorOne();
                    }
                }
            }
        }
    }
    public function routes() {
        $data = Route::get();
        return response()->json($data, 200);
    }
    public function update_head($dispatch) {
        $client = new Client;
        $der = $client->request('POST', $this->update_route, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'fleet_unique' => $dispatch['fleet_unique'],
                'suspend' => $dispatch['suspend'],
                'admin_suspend' => $dispatch['admin_suspend']
            ])
        ]);
        // $res = json_decode($der->getBody());
        // Log::info($res);
        return response()->json();
    }
    public function create_calend($dispatch) {
        $client = new Client;
        $der = $client->request('post', $this->create_calend, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'fleet_unique' => $dispatch['fleet_unique'],
                'date' => $dispatch['date'],
                'amount' => $dispatch['amount'],
                'off_peak' => $dispatch['off_peak'],
                'name' => $dispatch['name'],
                'lock' => $dispatch['lock'],
                'import_id' => $dispatch['import_id']
            ])
        ]);
        return response()->json();
    }
    public function update_calend($dispatch) {
        $client = new Client;
        $der = $client->request('post', $this->update_calend, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'date' => $dispatch['date'],
                'amount' => $dispatch['amount'],
                'import_id' => $dispatch['import_id']
            ])
        ]);
        return response()->json();
    }
    public function delete_calend($dispatch) {
        $client = new Client;
        $der = $client->request('post', $this->delete_calend, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'import_id' => $dispatch['import_id']
            ])
        ]);
        return response()->json();
    }
    public function head_dispatch($ticket_no) {
        $client = new Client;
        $der = $client->request('POST', $this->head_dispatch_url, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'ticket_no' => $ticket_no
            ])
        ]);        
        return response()->json();
    }
    public function head_book_update($booking_data) {
        $client = new Client;
        $der = $client->request('post', $this->head_book_update, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'group' => $booking_data['group'],
                'seaters' => $booking_data['seaters'],
                'amount' => $booking_data['amount'],
                'fullname' => $booking_data['fullname'],
                'id_no' => $booking_data['id_no'],
                'pick_up' => $booking_data['pick_up'],
                'mobile' => $booking_data['mobile'],
                'time' => $booking_data['time'],
                'travel_date' => $booking_data['travel_date'],
                'ticket_no' => $booking_data['ticket_no'],
                'departure' => $booking_data['departure'],
                'destination' => $booking_data['destination'],
                'ticket_token' => $booking_data['ticket_token'],
                'seat_no' => $booking_data['seat_no'],
                'fleet_unique' => $booking_data['fleet_unique']
            ])
        ]);
        return response()->json();
    }
}
