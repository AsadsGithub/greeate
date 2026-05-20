<?php

namespace Greeate\Greeate\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = ['name', 'guard_name', 'alias'];

    public static function isSystemRole(string $name): bool
    {
        return in_array($name, [config('greeate.super_admin_role', 'super-admin')], true);
    }
}
