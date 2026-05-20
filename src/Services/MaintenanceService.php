<?php

namespace Greeate\Greeate\Services;

use Greeate\Greeate\Models\MaintenanceMode;

class MaintenanceService
{
    public function isEnabled(): bool
    {
        $mode = MaintenanceMode::first();

        if (! $mode || ! $mode->is_enabled) {
            return false;
        }

        if ($mode->starts_at && now()->lt($mode->starts_at)) {
            return false;
        }

        if ($mode->ends_at && now()->gt($mode->ends_at)) {
            return false;
        }

        return true;
    }

    public function canAccess(?string $ip = null, ?array $roles = null): bool
    {
        $mode = MaintenanceMode::first();

        if (! $mode) {
            return true;
        }

        $ip = $ip ?? request()->ip();
        $whitelist = array_merge(
            $mode->ip_whitelist ?? [],
            config('greeate.maintenance.ip_whitelist', [])
        );

        if (in_array($ip, $whitelist, true)) {
            return true;
        }

        if ($roles && $mode->allowed_roles) {
            return ! empty(array_intersect($roles, $mode->allowed_roles));
        }

        return false;
    }

    public function getSettings(): ?MaintenanceMode
    {
        return MaintenanceMode::first();
    }
}
