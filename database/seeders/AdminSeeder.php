<?php

namespace Greeate\Greeate\Database\Seeders;

use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::firstOrCreate(
            ['email' => config('greeate.default_admin.email', 'admin@greeate.com')],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => config('greeate.default_admin.name', 'Super Admin'),
                'password' => Hash::make(config('greeate.default_admin.password', 'password')),
                'status' => 'active',
                'language' => 'en',
                'timezone' => 'UTC',
                'email_verified_at' => now(),
            ]
        );

        $role = Role::where('name', config('greeate.super_admin_role', 'super-admin'))->first();
        if ($role) {
            $admin->syncRoles([$role]);
        }
    }
}
