<?php

namespace Greeate\Greeate\Policies;

use Greeate\Greeate\Models\Admin;

class AdminPolicy
{
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('admins.view') || $admin->isSuperAdmin();
    }

    public function view(Admin $admin, Admin $model): bool
    {
        return $admin->can('admins.show') || $admin->isSuperAdmin();
    }

    public function create(Admin $admin): bool
    {
        return $admin->can('admins.create') || $admin->isSuperAdmin();
    }

    public function update(Admin $admin, Admin $model): bool
    {
        return $admin->can('admins.edit') || $admin->isSuperAdmin();
    }

    public function delete(Admin $admin, Admin $model): bool
    {
        return ($admin->can('admins.destroy') || $admin->isSuperAdmin()) && ! $model->isSuperAdmin();
    }
}
