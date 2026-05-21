<?php

namespace Greeate\Greeate;

use Greeate\Greeate\Models\Admin;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;

class GreeateAuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            if ($user instanceof Admin && $user->isSuperAdmin()) {
                return true;
            }

            return null;
        });

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('permissions')) {
                Permission::query()->pluck('name')->each(function (string $permission) {
                    Gate::define($permission, fn (Admin $admin) => $admin->hasPermissionTo($permission));
                });
            }
        } catch (\Throwable) {
            // Migrations not run yet
        }

        Activity::creating(function (Activity $activity) {
            $info = app(\Greeate\Greeate\Services\DeviceInfoService::class)->capture();
            $activity->properties = $activity->properties->merge($info);
        });
    }
}
