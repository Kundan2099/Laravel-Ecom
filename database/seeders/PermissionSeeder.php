<?php

namespace Database\Seeders;

use App\Enums\Permission as EnumsPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (EnumsPermission::cases() as $permission) {
            if (!Permission::where('name', $permission->value)->exists()) {
                Permission::create([
                    'name' => $permission->value,
                    'guard_name' => 'admin'
                ]);
            }
        }
    }
}