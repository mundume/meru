<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;
    protected $redirectTo = RouteServiceProvider::HOME;
    public function __construct()
    {
        $this->middleware('guest');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'c_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:10'],
            'c_mobile' => ['required', 'digits:10'],
            'id_no' => ['required', 'min:5', 'max:9', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'handle' => ['required', 'max:7', 'unique:users']
        ]);
    }
    protected function create(array $data)
    {
        $handle = strtolower(\Illuminate\Support\Str::random(7));
        $user = User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'c_name' => $data['c_name'],
            'mobile' => $data['mobile'],
            'c_mobile' => $data['c_mobile'],
            'id_no' => $data['id_no'],
            'c_county' => $data['c_county'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'handle' => $handle
        ]);
        $code = rand(1000, 9999).$user->id;
        Provider::create([
            'user_id' => $user->id,
            'name' => $user->c_name
        ]);
        Account::create([
            'user_id' =>  $user->id,
            'c_name' => $user->c_name,
            'mobile' => $user->mobile,
            'balance' => 0,
            'total_amount' => 0,
            'account_code' => $code
        ]);
        return $user;
    }
}
