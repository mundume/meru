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
                'c_name' => 'Meru Artist Coaches',
                'mobile' => '0799770833',
                'c_mobile' => '0799770833',
                'id_no' => '31842542',
                'c_county' => 'Meru',
                'email' => 'derrick.bundi27@gmail.com',
                'password' => bcrypt('123456'),
                'handle'=> 'abcdef'
            ],
            [
                'role_id' => 1,
                'fname' => 'Mike',
                'lname' => 'Julian',
                'c_name' => 'Meru Artist Coaches',
                'mobile' => '0710640098',
                'c_mobile' => '0710640098',
                'id_no' => '31842540',
                'c_county' => 'Meru',
                'email' => 'mike@meruartists.co.ke',
                'password' => bcrypt('123456'),
                'handle'=> 'abcdee'
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
				'c_name' => 'Meru Artist Coaches',
				'u_name' => 'Derrick',
				'mobile' => '0799770833',
				'balance' => 0,
                'total_amount' => 0,
                'account_code' => 4512411
            ],
            [
                'user_id' => 2,
				'c_name' => 'Meru Artist Coaches',
				'u_name' => 'Mike',
				'mobile' => '0710640098',
				'balance' => 0,
                'total_amount' => 0,
                'account_code' => 4512412
            ]
        ]);
        DB::table('providers')->insert([
            [
                'user_id' => 1,
                'c_name' => 'Meru Artist Coaches'
            ],
            [
                'user_id' => 2,
                'c_name' => 'Meru Artist Coaches'
            ]
        ]);
    }
}
