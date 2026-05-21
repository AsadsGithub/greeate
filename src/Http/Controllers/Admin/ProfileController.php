<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends BaseController
{
    public function __construct(protected AdminService $adminService) {}

    public function edit()
    {
        return view('greeate::admin.profile.edit', ['admin' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $admin = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:greeate_admins,email,'.$admin->id,
            'phone' => 'nullable|string|max:20',
            'timezone' => 'nullable|string|max:50',
            'language' => 'nullable|string|max:10',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $this->adminService->update($admin->id, $validated);

        return back()->with('success', __('greeate::messages.updated_successfully'));
    }
}
