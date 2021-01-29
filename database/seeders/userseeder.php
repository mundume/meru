<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class userseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'role_id' => 1,
                'fname' => 'Derrick',
                'lname' => 'Bundi',
                'c_name' => 'Shuttle App',
                'mobile' => '0799770833',
                'c_mobile' => '0799770833',
                'id_no' => '31842542',
                'c_county' => 'Meru',
                'email' => 'derrick.bundi27@gmail.com',
                'password' => bcrypt('123456'),
                'handle'=> 'abcdef'
            ]
        ]);
        DB::table('systems')->insert([
			'subscription' => 0,
			'buygoods' => 0,
			'paybill' => 4029669
        ]);
        DB::table('accounts')->insert([
            [
                'user_id' => 1,
				'c_name' => 'Shuttle App',
				'u_name' => 'Derrick',
				'mobile' => '0799770833',
				'balance' => 0,
                'total_amount' => 0,
                'account_code' => 4512411
            ]
        ]);
        DB::table('providers')->insert([
            'user_id' => 1,
            'c_name' => 'Shuttle App'
        ]);
    }
}
