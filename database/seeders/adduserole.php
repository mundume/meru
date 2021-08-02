<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User};
use Spatie\Permission\Models\Role;

class adduserole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_one = User::find(1);
        $role = Role::find(1);
        $permissions = [1,2,3];
        $role->syncPermissions($permissions);
        $user_one->assignRole([$role->id]);

        $user_two = User::find(2);
        $role = Role::find(1);
        $permissions = [1,2,3];
        $role->syncPermissions($permissions);
        $user_two->assignRole([$role->id]);
    }
}
