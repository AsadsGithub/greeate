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

        foreach ($this->permissions() as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(
            ['name' => config('greeate.super_admin_role', 'super-admin'), 'guard_name' => 'web'],
            ['alias' => 'Super Admin']
        );

        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web'],
            ['alias' => 'Admin']
        );

        $superAdmin->syncPermissions(Permission::all());
        $adminRole->syncPermissions(
            Permission::whereIn('name', $this->adminPermissions())->get()
        );
    }

    protected function permissions(): array
    {
        $resources = [
            'dashboard' => ['view'],
            'profile' => ['view', 'edit'],
            'admins' => ['view', 'create', 'show', 'edit', 'destroy', 'toggle-status'],
            'roles' => ['view', 'create', 'show', 'edit', 'destroy'],
            'permissions' => ['view'],
            'banners' => ['view', 'create', 'show', 'edit', 'destroy', 'toggle-status'],
            'faqs' => ['view', 'create', 'show', 'edit', 'destroy', 'toggle-status'],
            'languages' => ['view', 'create', 'show', 'edit', 'destroy', 'toggle-status'],
            'static-pages' => ['view', 'create', 'show', 'edit', 'destroy'],
            'contact-messages' => ['view', 'show', 'destroy'],
            'notifications' => ['view', 'create', 'send'],
            'broadcasts' => ['view', 'create', 'show', 'edit', 'destroy', 'send'],
            'activity-logs' => ['view', 'destroy'],
            'maintenance' => ['view', 'edit'],
        ];

        $permissions = [];
        foreach ($resources as $resource => $actions) {
            foreach ($actions as $action) {
                $permissions[] = "{$resource}.{$action}";
            }
        }

        foreach (['general', 'branding', 'firebase', 'contact', 'seo', 'features', 'activity-log'] as $group) {
            $permissions[] = "site-settings.{$group}.view";
            $permissions[] = "site-settings.{$group}.edit";
        }

        return $permissions;
    }

    protected function adminPermissions(): array
    {
        return array_filter($this->permissions(), fn ($p) => ! str_starts_with($p, 'roles.') && ! str_starts_with($p, 'permissions.'));
    }
}
