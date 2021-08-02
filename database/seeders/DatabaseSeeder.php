<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(permissionseeder::class);
        $this->call(roleseeder::class);
        $this->call(userseeder::class);
        $this->call(adduserole::class);
        $this->call(categorieseeder::class);
        $this->call(messageseeder::class);
    }
}
