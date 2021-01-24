<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\smscontroller;
use App\Models\{AgentUser,User,Account,Fleet,Category,Route,Calendarial,AgentRoute};
use DB;
use Hash;
use Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\{Str};

class dashboardcontroller extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        $user = auth()->user();
        $routes = Route::where([['user_id', $user->id]])->with('agent')->get();
        return view('dashboard.index', compact('routes'));
    }
    public function agents() {
        $user = auth()->user();
        $agents = AgentUser::where('company_id', $user->id)->with('user')->get();
        return view('dashboard.agents', compact('agents'));
    }
    public function add_agent(Request $request) {
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
        $password = strtolower(substr($request->first_name, 0, 2).mt_rand(1000,9999));
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
                'office_id' => $request->office_id
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
    public function fleets() {
        $fleets = Fleet::orderBy('id', 'desc')->where('user_id', auth()->user()->id)->get();
        return view('dashboard.fleets', compact('fleets'));
    }
    public function add_fleet(Request $request) {
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
        Fleet::where('id', base64_decode($id))->update(['suspend' => false]);
        Session::flash('success', 'Fleet unsuspended successfully.');
        return redirect()->back();
    }
    public function suspend_fleet($id) {
        Fleet::where('id', base64_decode($id))->update(['suspend' => true]);
        Session::flash('success', 'Fleet suspended successfully.');
        return redirect()->back();
    }
    public function edit_fleet(Request $request, $id) {
        $this->validate($request, [
            'fleet_id' => 'required|unique:fleets',
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
        $fl = Fleet::find(base64_decode($id));
        $fl->delete();
        Session::flash('success', 'Fleet deleted successfully.');
        return redirect()->back();
    }
    public function calendarial() {
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
            'name' => $name
        ];
        Calendarial::create($data);
        Session::flash('success', 'Peak added successfully.');
        return redirect()->back();
    }
    public function add_route() {
        $agents = AgentUser::where('company_id', auth()->user()->id)->with('user')->get();
        return view('dashboard.routes.add_route', compact('agents'));
    }
    public function create_route(Request $request) {
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
        foreach($routes as $route) {
            if($route->seaters == $request->seaters && $route->departure == $request->departure && $route->destination == $request->destination) {
                Session::flash('error', 'Oops, fleet with similar details exists.');
                return redirect()->back();
            }
        }
        DB::transaction(function() use($request,$user) {
            $unique = 'FLID'.mt_rand(1000,9999);
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
        $routes = Route::where('user_id', auth()->user()->id)->get();
        return view('dashboard.routes.routes', compact('routes'));
    }
    public function edit_route($id) {
        $route = Route::find(base64_decode($id));
        $agents = AgentUser::where('company_id', auth()->user()->id)->with('user')->get();
        $agent = AgentRoute::where('route_id', base64_decode($id))->with('user')->first();
        return view('dashboard.routes.edit_route', compact('route', 'agents', 'agent'));
    }
    public function edit_route_post(Request $request, $id) {
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
}
