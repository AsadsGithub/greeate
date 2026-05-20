<?php

namespace Greeate\Greeate\Services;

use Greeate\Greeate\Contracts\AdminRepositoryInterface;
use Greeate\Greeate\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminService
{
    public function __construct(
        protected AdminRepositoryInterface $repository
    ) {}

    public function create(array $data): Admin
    {
        $data['uuid'] = Str::uuid()->toString();
        $data['password'] = Hash::make($data['password']);

        $admin = $this->repository->create($data);

        if (! empty($data['role'])) {
            $admin->syncRoles([$data['role']]);
        }

        if (! empty($data['permissions'])) {
            $admin->syncPermissions($data['permissions']);
        }

        return $admin->load('roles');
    }

    public function update(int $id, array $data): Admin
    {
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $admin = $this->repository->update($id, $data);

        if (isset($data['role'])) {
            $admin->syncRoles([$data['role']]);
        }

        if (isset($data['permissions'])) {
            $admin->syncPermissions($data['permissions']);
        }

        return $admin->load('roles');
    }

    public function recordLogin(Admin $admin): void
    {
        $admin->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

        activity()
            ->causedBy($admin)
            ->performedOn($admin)
            ->log('login');
    }
}
