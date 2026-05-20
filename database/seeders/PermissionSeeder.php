<?php

namespace Greeate\Greeate\Database\Seeders;

use Greeate\Greeate\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = $this->getPermissions();

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate([
            'name' => config('greeate.super_admin_role', 'super-admin'),
            'guard_name' => 'web',
        ], ['alias' => 'Super Admin']);

        $superAdmin->syncPermissions(Permission::all());
    }

    protected function getPermissions(): array
    {
        $resources = ['admins', 'roles', 'permissions', 'banners', 'faqs', 'languages',
            'notifications', 'activity-logs', 'contact-messages', 'static-pages'];
        $actions = ['view', 'create', 'show', 'edit', 'destroy', 'toggle-status'];
        $permissions = [];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                $permissions[] = "{$resource}.{$action}";
            }
        }

        $settings = ['general', 'theme', 'firebase', 'contact', 'seo', 'activity-log'];
        foreach ($settings as $group) {
            $permissions[] = "site-settings.{$group}.view";
            $permissions[] = "site-settings.{$group}.edit";
        }

        return $permissions;
    }
}
