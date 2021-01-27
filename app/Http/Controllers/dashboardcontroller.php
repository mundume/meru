<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\smscontroller;
use App\Models\{AgentUser,User,Account,Fleet,Category,Route,Calendarial,AgentRoute,Booking,Parcel};
use DB;
use Hash;
use Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\{Str};
use Auth;

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
        $user = auth()->user();
        $routes = Route::where([['user_id', $user->id]])->with('agent')->get();
        $bookings = Booking::where('user_id', auth()->user()->id)->get()->count();
        $parcels = Parcel::where('user_id', auth()->user()->id)->get()->count();
        return view('dashboard.index', compact('routes', 'bookings', 'parcels'));
    }
    public function agents() {
        if($this->check_if_admin() == false) return redirect()->back();
        $user = auth()->user();
        $agents = AgentUser::where('company_id', $user->id)->with('user')->get();
        return view('dashboard.agents', compact('agents'));
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
        $user = auth()->user();
        $handle = strtolower(Str::random(7));
        $agent_unique = Str::random(7);
        $password = strtolower(substr($request->fname, 0, 2).mt_rand(1000,9999));
        DB::transaction(function() use($request,$password,$user,$handle,$agent_unique) {
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
            } else {
                $role = Role::find(3);
                $permissions = [3];
                $role->syncPermissions($permissions);
                $new_user->assignRole([$role->id]);
            }

            $account_data = [
                'user_id' =>  $new_user->id,
                'c_name' => $new_user->c_name,
                'mobile' => $new_user->mobile,
                'u_name' => $new_user->fname.$new_user->lname,
                'balance' => 0,
                'total_amount' => 0,
                'account_code' => $code
            ];
            Account::create($account_data);

            AgentUser::create([
                'company_id' => $user->id,
                'user_id' => $new_user->id,
                'agent_unique' => strtolower($agent_unique),
                'office_id' => $request->office_id,
                'pass_code' => $password
            ]);
        });
        $sms = new smscontroller;
        $message = "Login Code\r\nPasscode:".$password."\r\nhttp://127.0.0.1:8000/dashboard/\r\nRegards\r\n".auth()->user()->c_name." Team";
        $contact = '254'.substr($request->mobile, -9);
        $sms->send_sms($contact, $message);
        Session::flash('success', 'Agent added successfully.');
        return redirect()->back();
    }
    public function agent_lock($id) {}
    public function agent_unlock($id) {}
    public function add_fleets() {
        if($this->check_if_admin() == false) return redirect()->back();
        $fleets = Fleet::orderBy('id', 'desc')->where('user_id', auth()->user()->id)->get();
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
        $route = Route::where([['user_id', auth()->user()->id]])->get();
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
            ['user_id', auth()->user()->id],
            ['date', $request->date],
            ['fleet_unique', $route->fleet_unique]
            ])->first();
        if($exists) {
            Session::flash('error', 'Date already exists.');
            return redirect()->back();
        }
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
        Calendarial::create($data);
        Session::flash('success', 'Peak added successfully.');
        return redirect()->back();
    }
    public function edit_peak(Request $request, $id) {
        if($this->check_if_admin() == false) return redirect()->back();
        Calendarial::where('id', base64_decode($id))->update([
            'date' => $request->date,
            'amount' => $request->amount
        ]);
        Session::flash('success', 'Edited Successfully.');
        return redirect()->back();
    }
    public function delete_peak($id) {
        Calendarial::find(base64_decode($id))->delete();
        Session::flash('error', 'Deleted Successfully.');
        return redirect()->back();
    }
    public function add_route() {
        if($this->check_if_admin() == false) return redirect()->back();
        $agents = AgentUser::where('company_id', auth()->user()->id)->with('user')->get();
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
        $routes = Route::where('user_id', $user->id)->get();
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
        $routes = Route::where('user_id', auth()->user()->id)->with('agent')->get();
        return view('dashboard.routes.routes', compact('routes'));
    }
    public function edit_route($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $route = Route::find(base64_decode($id));
        $agents = AgentUser::where('company_id', auth()->user()->id)->with('user')->get();
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
        DB::transaction(function() use($request,$user,$agent,$route) {
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
                        $data = ['route_id' => $id, 'user_id' => $request->agent];
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
    public function top_up_agent(Request $request) {}
    public function suspend_route($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $route = Route::find(base64_decode($id));
        $route->suspend = true;
        $route->save();
        Session::flash('info', 'Route locked.');
        return redirect()->back();
    }
    public function unsuspend_route($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $route = Route::find(base64_decode($id));
        $route->suspend = false;
        $route->save();
        Session::flash('info', 'Route unlocked.');
        return redirect()->back();
    }
    public function admin_suspend_route($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $route = Route::find(base64_decode($id));
        $route->admin_suspend = true;
        $route->save();
        Session::flash('info', 'Route locked.');
        return redirect()->back();
    }
    public function admin_unsuspend_route($id) {
        if($this->check_if_admin() == false) return redirect()->back();
        $route = Route::find(base64_decode($id));
        $route->admin_suspend = false;
        $route->save();
        Session::flash('info', 'Route unlocked.');
        return redirect()->back();
    }
    public function booking_office(Request $request) {
        $route = Route::where([['id', $request->route_id], ['admin_suspend', false]])->get();
        return json_encode($route);
    }
    public function view_ticket_7($id) {
        $route = Route::find($id);
        return view('tickets.7', compact('route'));
    }
    public function view_ticket_10($id) {
        return view('tickets.10');
    }
    public function view_ticket_11($id) {
        return view('tickets.11');
    }
    public function view_ticket_14($id) {
        return view('tickets.14');
    }
    public function view_ticket_16($id) {
        return view('tickets.16');
    }
    public function bookings() {
        $bookings = Booking::where('user_id', auth()->user()->id)->get();
        return view('dashboard.bookings', compact('bookings'));
    }
    public function fleets() {
        return view('dashboard.fleet_dispatches');
    }
    public function parcels() {
        return view('dashboard.parcel_dispatches');
    }
    public function wallet() {
        return view('dashboard.wallet');
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
}
