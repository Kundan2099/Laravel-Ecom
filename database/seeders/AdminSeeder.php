<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

            $admin = new Admin();
            $admin->name = config('auth.admin.name');
            $admin->email = config('auth.admin.email');
            $admin->phone = config('auth.admin.phone');
            $admin->password = Hash::make(config('auth.admin.password'));
            $admin->generateAdminProfile();
            $admin->save();
    }
}
