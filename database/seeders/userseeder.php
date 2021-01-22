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
                'c_name' => 'Xwift Limited',
                'mobile' => '0799770833',
                'c_mobile' => '0799770833',
                'id_no' => '31842542',
                'c_county' => 'Meru',
                'email' => 'derrick.bundi27@gmail.com',
                'password' => bcrypt('?"sonko"?'),
                'handle'=> 'abcdef'
            ]
        ]);
        DB::table('systems')->insert([
			'subscription' => 0,
			'buygoods' => 0,
			'paybill' => 0
        ]);
        DB::table('accounts')->insert([
            [
                'user_id' => 1,
				'c_name' => 'Xwift Limited',
				'u_name' => 'Derrick',
				'mobile' => '0799770833',
				'balance' => 0,
                'total_amount' => 0,
                'account_code' => 4512411
            ]
        ]);
        DB::table('providers')->insert([
            'user_id' => 1,
            'c_name' => 'Xwift Limited'
        ]);
    }
}
