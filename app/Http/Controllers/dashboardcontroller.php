<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\{smscontroller,graphscontroller,pesacontroller};
use App\Models\{AgentUser,User,Account,Fleet,Category,Route,Calendarial,AgentRoute,Booking,Parcel,BookingUser,Payment,Cec,Dispatch,Provider,Dropoff,AgentCourier,Topup,Customer,Admin,Message};
use DB;
use Hash;
use Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\{Str,Arr};
use Illuminate\Support\Facades\Log;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\{Validator};
use App\Jobs\HeadUpdate;
use App\Jobs\Book\{BookDispatch,HeadBookUpdate};
use App\Jobs\Calendarial\{CreateCalendarial,DeleteCalendarial,UpdateCalendarial};

class dashboardcontroller extends Controller
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
        // if($this->check_if_admin() == false) return redirect()->back();
        if(Auth::check() && Auth::user()->hasRole('booking')) {
            return redirect()->route('agent.home');
        } else if(Auth::check() && Auth::user()->hasRole('courier')) {
            return redirect()->route('courier.home');
        } else {
            // $user = auth()->user();
            $routes = Route::with('agent')->get();
            $bookings = Booking::get()->count();
            $parcels = Parcel::get()->count();

            $bun = new graphscontroller;
            $der['chart_data'] = $bun->line_graph();

            return view('dashboard.index', compact('routes', 'bookings', 'parcels'), $der);
        }        
    }
    public function agents() {
        if($this->check_if_admin() == false) return redirect()->back();
        // $user = auth()->user();
        $agents = AgentUser::with(['user', 'dropoff'])->get();
        $provider = Provider::first();
        $offices = Dropoff::where('provider_id', $provider->id)->get();
        // $topups = Topup::orderBy('id', 'desc')->with('user')->get();
        $ids = [];
        foreach($agents as $agent) {
            array_push($ids, $agent->user_id);
        }
        $ids[] = 1;
        $admins = User::whereNotIn('id', $ids)->get();
        return view('dashboard.agents', compact('agents', 'offices','admins'));
    }
    public function add_agent(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back();
        $this->validate($request, [
            'email' => 'required',
            'id_no' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'c_name' => 'required',
            'mobile' => 'required | digits:10',
            'role' => 'required'
        ]);
        // $user = auth()->user();
        $handle = strtolower(Str::random(7));
        $agent_unique = Str::random(7);
        $password = strtoupper(substr($request->fname, 0, 2).mt_rand(1000,9999));
        DB::transaction(function() use($request,$password,$handle,$agent_unique) {
            $user_data = [
                'fname' => $request->fname,
                'lname' => $request->lname,
                'c_name' => $request->c_name,
                'mobile' => $request->mobile,
                'c_mobile' => $request->c_mobile,
                'id_no' => $request->id_no,
                'email' => $request->email,
                'handle' => $handle,
                'password' => Hash::make($password),
            ];
            $new_user = User::create($user_data);

            $code = rand(1000, 9999).$new_user->id;

            if($request->role == 0) {
                $role = Role::find(2);
                $permissions = [2,3];
                $role->syncPermissions($permissions);
                $new_user->assignRole([$role->id]);
            } else if($request->role == 1) {
                $role = Role::find(3);
                $permissions = [3];
                $role->syncPermissions($permissions);
                $new_user->assignRole([$role->id]);
            } else {
                $role = Role::find(1);
                $permissions = [1,2,3];
                $role->syncPermissions($permissions);
                $new_user->assignRole([$role->id]);
            }
            $cec = Dropoff::where('office_name', $request->office_name)->first();

            $agent_office = ['dropoff_id' => $cec->id, 'user_id' => $new_user->id];    
            $account_data = [
                'user_id' =>  $new_user->id,
                'c_name' => $new_user->c_name,
                'mobile' => $new_user->mobile,
                'u_name' => $new_user->fname." ".$new_user->lname,
                'balance' => 0,
                'total_amount' => 0,
                'account_code' => $code
            ];
            $agent_data = [
                'company_id' => 1,
                'user_id' => $new_user->id,
                'agent_unique' => strtolower($agent_unique),
                'office_id' => $cec->id,
                'pass_code' => $password
            ];
            if($request->role != 2) {
                Account::create($account_data);
                AgentCourier::create($agent_office);
                AgentUser::create($agent_data);
            }
        });
        $sms = new smscontroller;

        $message = Message::where('name', 'AGENT_CODE')->first()->body;
        $message = str_replace('%password%', $password, $message);
        $message = str_replace('%link%', config('app.url'), $message);
        $message = str_replace('%break%', "\r\n", $message);

        $contact = '254'.substr($request->mobile, -9);
        $sms->send_sms($contact, $message);
        Session::flash('success', 'Agent added successfully.');
        return redirect()->back();
    }
    public function edit_user($id) {

    }
    public function agent_lock($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $user = User::where('id', base64_decode($id))->update(['suspend' => Carbon::now()]);
        Session::flash('success', 'Agent locked.');
        return redirect()->back();
    }
    public function agent_unlock($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $user = User::where('id', base64_decode($id))->update(['suspend' => null]);
        Session::flash('success', 'Agent unlocked.');
        return redirect()->back();
    }
    public function add_fleets() {
        if($this->check_if_admin() == false) return redirect()->back();
        $fleets = Fleet::orderBy('id', 'desc')->get();
        return view('dashboard.fleets', compact('fleets'));
    }
    public function add_fleet(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back();
        $this->validate($request, [
            'fleet_id' => 'required|unique:fleets',
            'driver_name' => 'required',
            'driver_contact' => 'required|digits:10'
        ]);
        $data = [
            'fleet_id' => strtoupper($request->fleet_id),
            'driver_name' => $request->driver_name,
            'driver_contact' => $request->driver_contact,
            'capacity' => $request->capacity,
            'user_id' => auth()->user()->id
        ];
        Fleet::create($data);
        Session::flash('success', 'Fleet added successfully.');
        return redirect()->back();
    }
    public function unsuspend_fleet($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        Fleet::where('id', base64_decode($id))->update(['suspend' => false]);
        Session::flash('success', 'Fleet unsuspended successfully.');
        return redirect()->back();
    }
    public function suspend_fleet($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        Fleet::where('id', base64_decode($id))->update(['suspend' => true]);
        Session::flash('success', 'Fleet suspended successfully.');
        return redirect()->back();
    }
    public function edit_fleet(Request $request, $id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $this->validate($request, [
            'fleet_id' => 'required',
            'driver_name' => 'required',
            'driver_contact' => 'required|digits:10'
        ]);
        $data = [
            'fleet_id' => strtoupper($request->fleet_id),
            'driver_name' => $request->driver_name,
            'driver_contact' => $request->driver_contact,
            'capacity' => $request->capacity
        ];
        Fleet::where('id', base64_decode($id))->update($data);
        Session::flash('success', 'Fleet updated successfully.');
        return redirect()->back();
    }
    public function delete_fleet($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $fl = Fleet::find(base64_decode($id));
        $fl->delete();
        Session::flash('success', 'Fleet deleted successfully.');
        return redirect()->back();
    }
    public function calendarial() {
        if($this->check_if_admin() == false) return redirect()->back();
        $category = Category::get();
        $route = Route::get();
        $calendar = Category::with('calendarial')->get();
        $data = [];
        foreach($calendar as $bun) {
            array_push($data, ['categories'=> $bun->name, 'calendar' => $bun->calendarial]);
        }
        return view('dashboard.calendarial', compact('category', 'route', 'data'));
    }
    public function add_peak(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back();
        $route = Route::find($request->fleet_id);
        $exists = Calendarial::where([
            ['date', $request->date],
            ['fleet_unique', $route->fleet_unique]
            ])->first();
        if($exists) {
            Session::flash('error', 'Date already exists.');
            return redirect()->back();
        }
        DB::transaction(function() use($route, $request) {
            $name = substr($route->departure,0,4).'~'.substr($route->destination,0,4).'('.$route->seaters.')';
            $data = [
                'category_id' => $request->category_id,
                'fleet_unique' => $route->fleet_unique,
                'date' => $request->date,
                'amount' => $request->amount,
                'user_id' => auth()->user()->id,
                'off_peak' => $route->amount,
                'name' => $name,
                'lock' => $request->lock
            ];        
            $calend = Calendarial::create($data);
            $dispatch = [
                'fleet_unique'=>$route->fleet_unique,
                'date'=>$request->date,
                'amount'=>$request->amount,
                'off_peak'=>$route->amount,
                'name'=>$name,
                'lock'=>$request->lock,
                'import_id' => $calend->id
            ];
            CreateCalendarial::dispatch($dispatch)->delay(Carbon::now()->addSeconds(55));
        });
        Session::flash('success', 'Peak added successfully.');
        return redirect()->back();
    }
    public function edit_peak(Request $request, $id) {
        if($this->check_if_admin() == false) return redirect()->back();
        DB::transaction(function() use($request, $id) {
            Calendarial::where('id', base64_decode($id))->update([
                'date' => $request->date,
                'amount' => $request->amount
            ]);
            $dispatch = ['date'=>$request->date,'amount'=>$request->amount,'import_id'=>base64_decode($id)];
            UpdateCalendarial::dispatch($dispatch)->delay(Carbon::now()->addSeconds(55));
        });
        Session::flash('success', 'Edited Successfully.');
        return redirect()->back();
    }
    public function delete_peak($id) {
        DB::transaction(function() use($id) {
            $dispatch = ['import_id'=>base64_decode($id)];
            DeleteCalendarial::dispatch($dispatch)->delay(Carbon::now()->addSeconds(55));
            Calendarial::find(base64_decode($id))->delete();
        });
        Session::flash('error', 'Deleted Successfully.');
        return redirect()->back();
    }
    public function add_route() {
        if($this->check_if_admin() == false) return redirect()->back();
        $agents = AgentUser::with('user')->get();
        return view('dashboard.routes.add_route', compact('agents'));
    }
    public function create_route(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back();
        $this->validate($request, [
            'group' => 'required|min:3',
            'amount' => 'required',
            'seaters' => 'required',
            'departure' => 'required|min:2',
            'destination' => 'required|min:2',
            'mobile' => 'required|digits:10',
            'depart1' => 'required',
            'arriv1' => 'required'
        ]);
        $user = auth()->user();
        $routes = Route::get();
        $unique = 'FLID'.mt_rand(1000,9999);        
        foreach($routes as $route) {
            if($route->seaters == $request->seaters && $route->departure == $request->departure && $route->destination == $request->destination) {
                Session::flash('error', 'Oops, fleet with similar details exists.');
                return redirect()->back();
            }
        }
        DB::transaction(function() use($request,$user,$unique) {            
            $route_data = [
                'user_id' => $user->id,
                'group' => $request->group,
                'amount' => $request->amount,
                'seaters' => $request->seaters,
                'departure' => $request->departure,
                'destination' => $request->destination,
                'depart1' => $request->depart1,
                'arriv1' => $request->arriv1,
                'depart2' => $request->depart2,
                'arriv2' => $request->arriv2,
                'depart3' => $request->depart3,
                'arriv3' => $request->arriv3,
                'depart4' => $request->depart4,
                'arriv4' => $request->arriv4,
                'mobile' => $request->mobile,
                'pick_up' => $request->pick_up,
                'location' => $request->location,
                'fleet_unique' => $unique
            ];
            $add_route = Route::create($route_data);
            if($request->agent != 'ignore') {
                $data = [
                    'route_id' => $add_route->id,
                    'user_id' => $request->agent
                ];
                AgentRoute::create($data);
            }
        });
        Session::flash('success', 'Route added.');
        return redirect()->route('dashboard.routes');
    }
    public function routes() {
        if($this->check_if_admin() == false) return redirect()->back();
        $routes = Route::with('agent')->get();
        return view('dashboard.routes.routes', compact('routes'));
    }
    public function edit_route($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $route = Route::find(base64_decode($id));
        $agents = AgentUser::with('user')->get();
        $agent = AgentRoute::where('route_id', base64_decode($id))->with('user')->first();
        return view('dashboard.routes.edit_route', compact('route', 'agents', 'agent'));
    }
    public function edit_route_post(Request $request, $id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $this->validate($request, [
            'group' => 'required|min:3',
            'amount' => 'required',
            'seaters' => 'required',
            'departure' => 'required|min:2',
            'destination' => 'required|min:2',
            'mobile' => 'required|digits:10',
            'depart1' => 'required',
            'arriv1' => 'required'
        ]);
        $user = auth()->user();
        $route = Route::find(base64_decode($id));
        $agent = AgentRoute::where('route_id', base64_decode($id))->first();
        DB::transaction(function() use($request,$id,$user,$agent,$route) {
            $route_data = [
                'group' => $request->group,
                'amount' => $request->amount,
                'seaters' => $request->seaters,
                'departure' => $request->departure,
                'destination' => $request->destination,
                'depart1' => $request->depart1,
                'arriv1' => $request->arriv1,
                'depart2' => $request->depart2,
                'arriv2' => $request->arriv2,
                'depart3' => $request->depart3,
                'arriv3' => $request->arriv3,
                'depart4' => $request->depart4,
                'arriv4' => $request->arriv4,
                'mobile' => $request->mobile,
                'pick_up' =>  array_filter($request->pick_up, 'strlen'),
                'location' => $request->location
            ];
            $route->update($route_data);
            if($request->has('agent')) {
                if($request->agent != 'ignore') {
                    if($agent != null) {
                        $agent->update(['user_id' => $request->agent]);
                    } else {
                        $data = ['route_id' => base64_decode($id), 'user_id' => $request->agent];
                        AgentRoute::create($data);
                    }
                } else {
                    $agent->delete();
                }
            }
        });
        Session::flash('success', 'Route edited.');
        return redirect()->route('dashboard.routes');
    }
    public function delete_route($id) {
        //delete also relation with user
    }
    public function top_up_agent(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back();
        $validator = Validator::make($request->all(), [
            'amount' => 'integer|min:50',
            'email' => 'required'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'cood')->withInput();
        }
        $company_account = Account::where('user_id', auth()->user()->id)->first();
        if($request->amount > $company_account->balance) {
            Session::flash('error', 'Oops, account balance insufficient.');
            return redirect()->back();
        }
        $user = User::where('email', $request->email)->first();
        $agt = AgentUser::where('user_id', $user->id)->first();
        if(!$agt) {
            Session::flash('error', 'Oops, agent doesn\'t exist.');
            return redirect()->back();
        }
        if($agt->company_id != auth()->user()->id) {
            Session::flash('error', 'Oops, agent doesn\'t belong to your company.');
            return redirect()->back();
        }
        $agent_account = Account::where('user_id', $user->id)->first();
        DB::transaction(function() use($request, $agent_account, $company_account, $user) {
            $agent_account->update([
                'balance' => $agent_account->balance + $request->amount,
                'total_amount' => $agent_account->total_amount + $request->amount
            ]);
            $company_account->update([
                'balance' => $company_account->balance - $request->amount
            ]);
            $data = [
                'amount' => $request->amount,
                'sender' => auth()->user()->id,
                'receiver' => $user->id,
                'org_name' => auth()->user()->c_name
            ];
            Topup::create($data);
        });
        Session::flash('success', 'Agent account credited successfully');
        return redirect()->back();
    }
    public function suspend_route($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $route = Route::find(base64_decode($id));
        $route->suspend = true;
        $route->save();        
        $dispatch = ['fleet_unique'=>$route->fleet_unique,'admin_suspend'=>$route->admin_suspend,'suspend'=>true];
        HeadUpdate::dispatch($dispatch)->delay(Carbon::now()->addSeconds(30));
        Session::flash('info', 'Route locked.');
        return redirect()->back();
    }
    public function unsuspend_route($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $route = Route::find(base64_decode($id));
        $route->suspend = false;
        $route->save();
        $dispatch = ['fleet_unique'=>$route->fleet_unique,'admin_suspend'=>$route->admin_suspend,'suspend'=>false];
        HeadUpdate::dispatch($dispatch)->delay(Carbon::now()->addSeconds(30));
        Session::flash('info', 'Route unlocked.');
        return redirect()->back();
    }
    public function admin_suspend_route($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $route = Route::find(base64_decode($id));
        $route->admin_suspend = true;
        $route->save();
        // dd($route);
        $dispatch = ['fleet_unique'=>$route->fleet_unique,'admin_suspend'=>true,'suspend'=>$route->suspend];
        HeadUpdate::dispatch($dispatch)->delay(Carbon::now()->addSeconds(30));
        Session::flash('info', 'Route locked.');
        return redirect()->back();
    }
    public function admin_unsuspend_route($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $route = Route::find(base64_decode($id));
        $route->admin_suspend = false;
        $route->save();
        $dispatch = ['fleet_unique'=>$route->fleet_unique,'admin_suspend'=>false,'suspend'=>$route->suspend];
        HeadUpdate::dispatch($dispatch)->delay(Carbon::now()->addSeconds(30));
        Session::flash('info', 'Route unlocked.');
        return redirect()->back();
    }
    public function booking_office(Request $request) {
        $route = Route::where([['id', $request->route_id], ['admin_suspend', false]])->get();
        return json_encode($route);
    }
    public function view_ticket_7($id) {
        // $filter_user = app_filterAgent();
        $route = Route::find($id);
        if($route->seaters != 7) return redirect()->route('dashboard.index');
        $current_bookings = Booking::where([
            ['dispatched', false],
            ['departure', $route->departure],
            ['destination', $route->destination],
            ['is_paid', true],
            ['seaters', 7],
            ['suspended', false]
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->get();
        $online_bookings = Booking::where([
            ['dispatched', false],
            ['departure', $route->departure],
            ['destination', $route->destination],
            ['is_paid', true],
            ['seaters', 7],
            ['suspended', true]
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->get();
        $fleets = Fleet::where([['suspend', false]])->get();
        return view('tickets.7', compact('route','current_bookings','online_bookings', 'fleets'));
    }
    public function view_ticket_10($id) {
        // $filter_user = app_filterAgent();
        $route = Route::find($id);
        if($route->seaters != 10) return redirect()->route('dashboard.index');
        $current_bookings = Booking::where([
            ['dispatched', false],
            ['departure', $route->departure],
            ['destination', $route->destination],
            ['is_paid', true],
            ['seaters', 10],
            ['suspended', false]
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->get();
        $online_bookings = Booking::where([
            ['dispatched', false],
            ['departure', $route->departure],
            ['destination', $route->destination],
            ['is_paid', true],
            ['seaters', 10],
            ['suspended', true]
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->get();
        $fleets = Fleet::where([['suspend', false]])->get();
        return view('tickets.10', compact('route','current_bookings','online_bookings', 'fleets'));
    }
    public function view_ticket_11($id) {
        // $filter_user = app_filterAgent();
        $route = Route::find($id);
        if($route->seaters != 11) return redirect()->route('dashboard.index');
        $current_bookings = Booking::where([
            ['dispatched', false],
            ['departure', $route->departure],
            ['destination', $route->destination],
            ['is_paid', true],
            ['seaters', 11],
            ['suspended', false]
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->get();
        $online_bookings = Booking::where([
            ['dispatched', false],
            ['departure', $route->departure],
            ['destination', $route->destination],
            ['is_paid', true],
            ['seaters', 11],
            ['suspended', true]
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->get();
        $fleets = Fleet::where([['suspend', false]])->get();
        return view('tickets.11', compact('route','current_bookings','online_bookings', 'fleets'));
    }
    public function view_ticket_14($id) {
        // $filter_user = app_filterAgent();
        $route = Route::find($id);
        if($route->seaters != 14) return redirect()->route('dashboard.index');
        $current_bookings = Booking::where([
            ['dispatched', false],
            ['departure', $route->departure],
            ['destination', $route->destination],
            ['is_paid', true],
            ['seaters', 14],
            ['suspended', false]
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->get();
        $online_bookings = Booking::where([
            ['dispatched', false],
            ['departure', $route->departure],
            ['destination', $route->destination],
            ['is_paid', true],
            ['seaters', 14],
            ['suspended', true]
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->get();
        $fleets = Fleet::where([['suspend', false]])->get();
        return view('tickets.14', compact('route','current_bookings','online_bookings', 'fleets'));
    }
    public function view_ticket_16($id) {
        // $filter_user = app_filterAgent();
        $route = Route::find($id);
        if($route->seaters != 16) return redirect()->route('dashboard.index');
        $current_bookings = Booking::where([
            ['dispatched', false],
            ['departure', $route->departure],
            ['destination', $route->destination],
            ['is_paid', true],
            ['seaters', 16],
            ['suspended', false]
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->get();
        $online_bookings = Booking::where([
            ['dispatched', false],
            ['departure', $route->departure],
            ['destination', $route->destination],
            ['is_paid', true],
            ['seaters', 16],
            ['suspended', true]
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->get();
        $fleets = Fleet::where([['suspend', false]])->get();
        return view('tickets.16', compact('route','current_bookings','online_bookings', 'fleets'));
    }
    public function bookings(Request $request) {        
        if($this->check_if_admin() == false) return redirect()->back();
        // $user = auth()->user();
        if($request->created_at) {
            $bookings = Booking::whereDate('created_at', $request->created_at)->get();
        } else {
            $bookings = Booking::paginate(200);
        }
        return view('dashboard.bookings', compact('bookings'));
    }
    public function future_bookings() {
        $bookings = Booking::where([
            ['is_paid', 1],
            ['dispatched', 0]
            ])->whereDate('travel_date', '>', Carbon::now()->format('Y-m-d'))->get();
        $routes = Route::get();
        return view('dashboard.future_bookings', compact('bookings', 'routes'));
    }
    public function future_bookings_check(Request $request) {
        $data = [
            'fleet_id' => $request->fleet_id,
            'travel_date' => $request->date,
            'time' => $request->time
        ];     
        return redirect()->route('dashboard.future_booking', $data);
    }
    public function future_booking(Request $request) {
        $fleet = Route::find($request->fleet_id);
        $bookings = Booking::where([
            ['is_paid', 1],
            ['dispatched', 0],
            ['travel_date', $request->travel_date],
            ['fleet_unique', $fleet->fleet_unique],
            ['time', $request->time]
            ])->get();
        $routes = Route::get();
        $date = $request->travel_date;
        $time = $request->time;
        return view('dashboard.future_bookings_check', compact('bookings', 'fleet', 'routes', 'date', 'time'));
    }
    public function look_for_time(Request $request) {
        $data = Route::where('id', $request->cat_id)->get(['depart1', 'depart2', 'depart3', 'depart4']);
        return json_encode($data);
    }
    public function filter_bookings(Request $request) {
        return redirect()->route('dashboard.bookings', ['created_at' => $request->date]);
    }
    public function parcels() {
        if($this->check_if_admin() == false) return redirect()->back();
        $filter_user = app_filterAgent();
        $parcels = Parcel::orderBy('id', 'desc')->where([['user_id', $filter_user]])->with(['dropoff','fleet'])->get();
        $fleets = Fleet::where([['user_id', $filter_user], ['suspend', false]])->get();
        return view('dashboard.parcel_dispatches', compact('parcels', 'fleets'));
    }
    public function agent_parcels() {
        $filter_user = app_filterAgent();
        $agent = AgentCourier::where('user_id', auth()->user()->id)->first();
        $parcels = Parcel::orderBy('id', 'desc')->where([['progress', 1], ['destination_office', $agent->dropoff_id]])->get();        
        $fleets = Fleet::where([['user_id', $filter_user], ['suspend', false]])->get();
        return view('dashboard.agent_parcels_dispatches', compact('parcels', 'fleets'));
    }
    public function wallet(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back();
        // $user = auth()->user();
        if($request->created_at) {
            $payments = Payment::whereDate('created_at', $request->created_at)->get();
        } else {
            $payments = Payment::get();
        }
        return view('dashboard.wallet', compact('payments'));
    }
    public function filter_wallet(Request $request) {
        return redirect()->route('dashboard.wallet', ['created_at' => $request->date]);
    }
    public function edit_account() {
        $user = auth()->user();
        return view('dashboard.edit_account', compact('user'));
    }
    public function update_account(Request $request, $id) {
        $this->validate($request, [
            'mobile' => 'required|digits:10',
            'c_mobile' => 'required|digits:10',
            'fname' => 'required',
            'lname' => 'required',
            'password' => 'required'
        ]);
        User::where('id', base64_decode($id))->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'mobile' => $request->mobile,
            'c_mobile' => $request->c_mobile,
            'password' => Hash::make($request->password)
        ]);
        Session::flash('info', 'Account updated successfully.');
        return redirect()->route('dashboard.index');
    }
    public function moderator_sell_ticket(Request $request) {
        $this->validate($request, [
            'mobile' => 'required|digits:10',
            'seat_no' => 'required',
            'amount' => 'required|numeric'
        ]);
        if($request->travel_date != null && $request->time == null) {
            Session::flash('error', 'Oops, time can\'t be empty.');
            return redirect()->back();
        }
        $filter_date = app_filterDate($request->travel_date, $request->time);
        $filter_user = app_filterAgent();
        $books = Booking::where([
            ['user_id', auth()->user()->id],
            ['fleet_unique', $request->fleet_unique],
            ['seaters', $request->seaters],
            ['dispatched', 0],
            ['time', $filter_date['time']],
            ['travel_date', $filter_date['date']],
            ['suspended', 0],
            ['is_paid', true]
            ])->get();

        foreach($books as $book) {
            if($request->seat_no == $book->seat_no) {
                Session::flash('error', 'Oops, seat number already booked');
                return redirect()->back();
            }
        }
        $ticket_no = mt_rand(1000, 9000);
        $token = hash('sha256', Str::random());
        $contact = '254'.substr($request->mobile,-9);
        if($request->payment_method == 'mpesa') {
            $stk = new pesacontroller;
            $push = $stk->prompt_push(
                $ticket_no,
                $request->amount,
                $contact,
                route('payment.callback'),
                'PAYMENTS'
            );
            //perform check ~ but ignored
            DB::transaction(function() use($push,$ticket_no,$filter_date,$filter_user,$contact,$request,$token) {
                $booking_data = [
                    'user_id' => $filter_user,
                    // 'CheckoutRequestID' => $push->CheckoutRequestID,
                    'CheckoutRequestID' => null,
                    'group' => $request->group,
                    'seaters' => $request->seaters,
                    'amount' => $request->amount,
                    'fullname' => $request->fullname,
                    'id_no' => $request->id_no,
                    'pick_up' => 'Office Ticket',
                    'mobile' => $contact,
                    'time' => $filter_date['time'],
                    'travel_date' => $filter_date['date'],
                    'ticket_no' => $ticket_no,
                    'departure' => $request->departure,
                    'destination' => $request->destination,
                    'ticket_token' => $token,
                    'seat_no' => $request->seat_no,
                    'is_paid' => true,
                    'payment_method' => $request->payment_method,
                    'fleet_unique' => $request->fleet_unique
                ];
                $payment_data = [
                    'user_id' => $filter_user,
                    'ResultCode' => 0,
                    'ResultDesc' => 'Moderator Ticket',
                    'MerchantRequestID' => 0,
                    // 'MerchantRequestID' => $push->MerchantRequestID,
                    // 'CheckoutRequestID' => $push->CheckoutRequestID,
                    'CheckoutRequestID' => 0,
                    'mpesaReceiptNumber' => 0,
                    'ticket_no' => $ticket_no,
                    'amount' => $request->amount,
                    'phoneNumber' => $contact,
                    'TransactionDate' => Carbon::now()
                ];
                $book = Booking::create($booking_data);
                Payment::create($payment_data);
                $exist_agent = app_existsAgent();
                if($exist_agent == 1) {
                    $agen = new BookingUser;
                    $agen->booking_id = $book->id;
                    $agen->user_id = auth()->user()->id; 
                    $agen->save();
                }
                //update head booking; either before payment or after payment
                //sms either called on successfully paid ticket
            });
            Session::flash('success', 'Ticket generated.');
            return redirect()->back();
        } else {
            DB::transaction(function() use($ticket_no,$filter_date,$filter_user,$contact,$request,$token) {
                $booking_data = [
                    'user_id' => $filter_user,
                    'CheckoutRequestID' => null,
                    'group' => $request->group,
                    'seaters' => $request->seaters,
                    'amount' => $request->amount,
                    'fullname' => $request->fullname,
                    'id_no' => $request->id_no,
                    'pick_up' => 'Office Ticket',
                    'mobile' => $contact,
                    'time' => $filter_date['time'],
                    'travel_date' => $filter_date['date'],
                    'ticket_no' => $ticket_no,
                    'departure' => $request->departure,
                    'destination' => $request->destination,
                    'ticket_token' => $token,
                    'seat_no' => $request->seat_no,
                    'is_paid' => true,
                    'payment_method' => $request->payment_method,
                    'fleet_unique' => $request->fleet_unique
                ];
                $payment_data = [
                    'user_id' => $filter_user,
                    'ResultCode' => 0,
                    'ResultDesc' => 'Moderator Ticket',
                    'MerchantRequestID' => 0,
                    'CheckoutRequestID' => 0,
                    'mpesaReceiptNumber' => 0,
                    'ticket_no' => $ticket_no,
                    'amount' => $request->amount,
                    'phoneNumber' => $contact,
                    'TransactionDate' => Carbon::now()
                ];
                $book = Booking::create($booking_data);
                Payment::create($payment_data);
                $exist_agent = app_existsAgent();
                if($exist_agent == 1) {
                    $agen = new BookingUser;
                    $agen->booking_id = $book->id;
                    $agen->user_id = auth()->user()->id; 
                    $agen->save();
                }
                HeadBookUpdate::dispatch($booking_data)->delay(Carbon::now()->addSeconds(2));

                $message = Message::where('name', 'PAID_TICKET')->first()->body;
                $message = str_replace('%ticket_no%', $ticket_no, $message);
                $message = str_replace('%amount%', $request->amount, $message);
                $message = str_replace('%seat_no%', $request->seat_no, $message);
                $message = str_replace('%link%', config('app.url'), $message);
                $message = str_replace('%break%', "\r\n", $message);
                $sms = new smscontroller;
                $sms->send_sms($contact, $message);
            });
            Session::flash('success', 'Ticket generated.');
            return redirect()->back();
        }
    }
    public function delay_commuter($id) {
        Booking::find(base64_decode($id))->update([
            'suspended' => 1
        ]);
        Session::flash('info', 'Ticket pushed to waiting.');
        return redirect()->back();
    }
    public function activate_commuter($id) {
        Booking::find(base64_decode($id))->update([
            'suspended' => false
        ]);
        Session::flash('info', 'Ticket activated.');
        return redirect()->back();
    }
    public function dispatch_fleet(Request $request, $id, $fleet_unique) {
        $new_id = app_filterAgent();
        $path = public_path('pdfs/');
        $rout = Route::where('fleet_unique', $fleet_unique)->first();
        $books = Booking::where([
            ['user_id', $new_id],
            ['fleet_unique', $fleet_unique],
            ['seaters', $rout->seaters],
            ['dispatched', false],
            ['suspended', false],
            ['is_paid', true]
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->get();
        $cash = Booking::where([
            ['user_id', $new_id],
            ['fleet_unique', $fleet_unique],
            ['seaters', $rout->seaters],
            ['dispatched', false],
            ['suspended', false],
            ['is_paid', true],
            ['payment_method', 'cash']
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->sum('amount');
        $mpesa = Booking::where([
            ['user_id', $new_id],
            ['fleet_unique', $fleet_unique],
            ['seaters', $rout->seaters],
            ['dispatched', false],
            ['suspended', false],
            ['is_paid', true],
            ['payment_method', 'mpesa']
        ])->whereDate('travel_date', Carbon::today()->format('Y-m-d'))->sum('amount');
        $der = $path.$fleet_unique.'-'.date('Y-m-d-H-i').'.pdf';
        DB::transaction(function() use($request,$books,$fleet_unique,$der,$rout,$cash,$mpesa) {
            $ticket_no = [];
            foreach($books as $book) {
                $book->update([
                    'dispatched' => 1                 
                ]);
                array_push($ticket_no, $book->ticket_no);
            }
            Dispatch::create([
                'dispatch' => json_encode($books),                
                'fleet_id' => $fleet_unique,
                'readable_fleet_id' => $request->readable_fleet_id
            ]);
            $pdf = PDF::loadView('prints/fleet_list', compact('books', 'rout'))->setPaper('a4')->setWarnings(false)->save($der);
            $cec = Cec::create([
                'path' => $der,
                'fleet_id' => $fleet_unique,
                'no_of_commuters' => $books->count(),
                'readable_fleet_id' => $request->readable_fleet_id,
                'cash' => $cash,
                'mpesa' => $mpesa,
                'total_amount' => $cash+$mpesa
            ]);
            BookDispatch::dispatch($ticket_no)->delay(Carbon::now()->addSeconds(10));
        });
        Session::flash('success', 'Fleet dispatched successfully');
        return redirect()->back();
    }
    public function dispatch_fleet_future(Request $request, $id, $route, $date) {
        $path = public_path('pdfs/');
        $rout = Route::where('fleet_unique', $route)->first();
        $books = Booking::where([
            ['fleet_unique', $route],
            ['seaters', $rout->seaters],
            ['dispatched', 0],
            ['travel_date', $date],
            ['suspended', 0],
            ['is_paid', 1]
        ])->get();
        $cash = Booking::where([
            ['fleet_unique', $route],
            ['seaters', $rout->seaters],
            ['dispatched', false],
            ['suspended', false],
            ['travel_date', $date],
            ['is_paid', true],
            ['payment_method', 'cash']
        ])->sum('amount');
        $mpesa = Booking::where([
            ['fleet_unique', $route],
            ['seaters', $rout->seaters],
            ['dispatched', false],
            ['suspended', false],
            ['travel_date', $date],
            ['is_paid', true],
            ['payment_method', 'mpesa']
        ])->sum('amount');
        $der = $path.$route.'-'.date('Y-m-d-H-i').'.pdf';
        DB::transaction(function() use($request, $books,$route,$der,$rout,$date,$cash, $mpesa) {
            $ticket_no = [];
            foreach($books as $book) {
                $book->update([
                    'dispatched' => 1
                ]);
                array_push($ticket_no, $book->ticket_no);
            }
            $dispatch = Dispatch::create([
                'dispatch' => json_encode($books),                
                'fleet_id' => $route,
                'readable_fleet_id' => $request->readable_fleet_id
            ]);
            $pdf = PDF::loadView('prints/fleet_list', compact('books', 'rout'))->setPaper('a4')->setWarnings(false)->save($der);
            // return $pdf->stream($der);
            $cec = Cec::create([
                'path' => $der,
                'fleet_id' => $route,
                'no_of_commuters' => $books->count(),
                'created_at' => $date,
                'readable_fleet_id' => $request->readable_fleet_id,
                'cash' => $cash,
                'mpesa' => $mpesa,
                'total_amount' => $cash+$mpesa
            ]);
            BookDispatch::dispatch($ticket_no)->delay(Carbon::now()->addSeconds(10));
        });
        Session::flash('success', 'Fleet dispatched successfully');
        return redirect()->back();
    }
    public function dispatch_fleet_print($fleet_unique) {
        $print = Cec::orderBy('id','desc')->where('fleet_id', $fleet_unique)->first();
        if($print) {
            return response()->download($print->path);
        } 
        Session::flash('info', 'Oops, dispatch fleet first to download the list');
        return redirect()->back();
    }
    public function dispatches(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back();
        $routes = Route::get()->pluck('fleet_unique');
        if($request->created_at) {
            $dispatchs = Cec::orderBy('id', 'desc')->whereDate('created_at', $request->created_at)->whereIn('fleet_id', $routes)->with('route')->get();
        } else {
            $dispatchs = Cec::orderBy('id', 'desc')->whereIn('fleet_id', $routes)->with('route')->get();
        }
        return view('dashboard.fleet_dispatches', compact('dispatchs'));
    }
    public function search_dispatches(Request $request) {
        return redirect()->route('dashboard.dispatches', ['created_at' => $request->date]);
    }
    public function fetch_balance() {
        if(!auth()->user()) return redirect()->back();
        $data = Account::where('user_id', auth()->user()->id)->select('balance')->first();
        $data = round($data->balance, 2);
        return json_encode($data);
    }
    public function sms_blasts() {
        if($this->check_if_admin() == false) return redirect()->back();
        $customers = Customer::orderBy('id', 'desc')->where('active', true)->get();
        return view('dashboard.sms_blast', compact('customers'));
    }
    public function add_customer(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back();
        $this->validate($request, [
            'mobile' => 'required|digits:10'
        ]);
        $cus = Customer::where([['active', 1]])->get();
        $contacts = [];
        foreach($cus as $cu) {
            array_push($contacts, $cu->mobile);
        }
        if(in_array($request->mobile, $contacts)) {
            Session::flash('error', 'Mobile number already exists');
            return redirect()->back();
        }
        // dd($contacts);
        $data = [
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'mobile' => $request->mobile
        ];
        Customer::create($data);
        Session::flash('success', 'Contact added.');
        return redirect()->back();
    }
    public function trash_customer($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        Customer::where('id', base64_decode($id))->update(['active' => false]);
        Session::flash('success', 'Contact deleted.');
        return redirect()->back();
    }
    public function import_contacts($id) {
        $book = Booking::where('user_id', base64_decode($id))->get();
        foreach($book->unique('mobile') as $data) {
            $result = [
                'user_id' => base64_decode($id),
                'name' => $data->fullname,
                'mobile' => $data->mobile
            ];
            Customer::create($result);
        }
        Session::flash('success', 'Contacts imported successfully from bookings.');
        return redirect()->back();
    }
    public function contacts_delete($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $del = Customer::where('user_id', base64_decode($id))->get();
         foreach($del as $dele) {
             $dele->delete();
         }
         Session::flash('success', 'Contacts deleted.');
         return redirect()->back();
    }
    public function send_blast_sms(Request $request) {
        $contacts = Customer::where([['active', true]])->get();
         $message = $request->message;
         $contact = [];
         foreach($contacts->unique('mobile') as $cont) {
             array_push($contact, $cont->mobile);
         }
         $send = new smscontroller;
         $send->send_sms($contact, $message);        
         Session::flash('success', 'Messages sent.');
         return redirect()->back();
    }
    public function daily_reporting(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back();
        if(auth()->user()->role_id != 1) {
            Session::flash('error', 'Oops, you are not allowed to access this page.');
            return redirect()->back();
        }
        $admins = Admin::get();
        if($request->start_date) {
            $end = Carbon::parse($request->end_date);
            $start = Carbon::parse($request->start_date);
            $dates = collect();
            for($i=0;$i<=$end->diffInDays($start);$i++) {
                $date = (clone $start)->addDays($i)->format('Y-m-d');
                $dates->put($date, 0);
            }
            $bookings = Booking::where([['is_paid', true], ['created_at', '>=', $dates->keys()->first()]])
                                    ->groupBy('date')->orderBy('date')
                                    ->get(([
                                        DB::raw('DATE(created_at) as date'),
                                        DB::raw('SUM(amount) as "views"')
                                    ]))->pluck('views', 'date');
            $booking_data = $dates->merge($bookings);
            $parcels = Parcel::where([['is_paid', true], ['created_at', '>=', $dates->keys()->first()]])
                            ->groupBy('date')->orderBy('date')
                            ->get(([
                                DB::raw('DATE(created_at) as date'),
                                DB::raw('SUM(service_provider_amount) as "views"')
                            ]))->pluck('views', 'date');
            $parcel_data = $dates->merge($parcels);
        } else {
            $end = Carbon::now()->subDays(7);
            $start = Carbon::now()->subDays(14);
            $dates = collect();
            for($i=0;$i<=$end->diffInDays($start);$i++) {
                $date = (clone $start)->addDays($i)->format('Y-m-d');
                $dates->put($date, 0);
            }
            $bookings = Booking::where([['is_paid', true], ['created_at', '>=', $dates->keys()->first()]])
                                    ->groupBy('date')->orderBy('date')
                                    ->get(([
                                        DB::raw('DATE(created_at) as date'),
                                        DB::raw('SUM(amount) as "views"')
                                    ]))->pluck('views', 'date');
            $booking_data = $dates->merge($bookings);
            $parcels = Parcel::where([['is_paid', true], ['created_at', '>=', $dates->keys()->first()]])
                            ->groupBy('date')->orderBy('date')
                            ->get(([
                                DB::raw('DATE(created_at) as date'),
                                DB::raw('SUM(service_provider_amount) as "views"')
                            ]))->pluck('views', 'date');
            $parcel_data = $dates->merge($parcels);
        }
        return view('dashboard.daily_reporting', compact('admins', 'booking_data', 'parcel_data'));
    }
    public function filter_report(Request $request) {
        return redirect()->route('dashboard.daily_reporting',['start_date' => $request->start_date, 'end_date' => $request->end_date]);
    }
    public function add_admin(Request $request) {
        if($this->check_if_admin() == false) return redirect()->back();
        Admin::create([
            'name' => $request->name,
            'mobile' => $request->mobile
        ]);
        Session::flash('success', 'Admin added.');
        return redirect()->back();
    }
    public function trash_admin($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $del = Admin::find(base64_decode($id));
        $del->delete();
        Session::flash('success', 'Admin deleted.');
        return redirect()->back();

    }
    public function notify_admin() {
        $booking = Booking::where([['travel_date', Carbon::today()->format('Y-m-d')],['is_paid', true]])->get();
        $booking_count = $booking->count();
        $booking_sum = $booking->sum('amount');
        $parcel = Parcel::where('is_paid', true)->whereDate('created_at', Carbon::today()->format('Y-m-d'))->get();
        $parcel_count = $parcel->count();
        $parcel_sum = $parcel->sum('service_provider_amount');

        // $data = [$booking_count, $booking_sum, $parcel_count, $parcel_sum];
        // Log::info($data);

        $message = Message::where('name', 'ADMIN_REPORT')->first()->body;
        $message = str_replace('%booking_count%', $booking_count, $message);
        $message = str_replace('%booking_sum%', $booking_sum, $message);
        $message = str_replace('%parcel_count%', $parcel_count, $message);
        $message = str_replace('%parcel_sum%', $parcel_sum, $message);
        $message = str_replace('%break%', "\r\n", $message);

        $contact = [];
        $admins = Admin::get();
        foreach($admins as $admin) {
            array_push($contact, $admin->mobile);
        }
        $sms = new smscontroller;
        $sms->send_sms($contact, $message);
    }
}
