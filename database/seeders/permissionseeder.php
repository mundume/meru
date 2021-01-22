<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class permissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = ['admin-show', 'booking-show', 'courier-show'];
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
