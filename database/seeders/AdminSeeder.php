<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $check_if_exist = Admin::where('email', config('auth.admin.email'))
            ->where('phone', config('auth.admin.phone'))
            ->doesntExist();

        if ($check_if_exist) {

            $role = new Role();
            $role->name = 'Administrator';
            $role->guard_name = 'admin';
            $role->save();

            foreach (Permission::all() as $permission) {
                $role->givePermissionTo($permission);
            }

            $admin = new Admin();
            $admin->name = config('auth.admin.name');
            $admin->email = config('auth.admin.email');
            $admin->phone = config('auth.admin.phone');
            $admin->password = Hash::make(config('auth.admin.password'));
            $admin->generateAdminProfile();
            $admin->assignRole($role);
            $admin->save();
        }
    }
}
