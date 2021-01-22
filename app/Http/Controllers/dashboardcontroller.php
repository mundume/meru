<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\smscontroller;
use App\Models\{AgentUser};
use DB;
use Hash;
use Spatie\Permission\Models\Role;

class dashboardcontroller extends Controller
{
    public function index() {
        return view('dashboard.index');
    }
    public function agents() {
        $user = auth()->user();
        $agents = AgentUser::where('company_id', $user->id)->get();
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
        $password = strtolower(substr($request->first_name, 0, 2).mt_rand(1000,9999));
        DB::transaction(function() use($request,$password,$user,$handle) {
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
                $new_user->assRole([$role->id]);
            } else {
                $role = Role::find(3);
                $permissions = [3];
                $role->syncPermissions($permissions);
                $new_user->assRole([$role->id]);
            }

            $account_data = [
                'user_id' =>  $new_user->id,
                'c_name' => $new_user->c_name,
                'mobile' => $new_user->mobile,
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
}
