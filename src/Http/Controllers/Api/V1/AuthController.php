<?php

namespace Greeate\Greeate\Http\Controllers\Api\V1;

use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Http\Resources\AdminResource;
use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseController
{
    public function __construct(protected AdminService $adminService) {}

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => [__('greeate::messages.invalid_credentials')],
            ]);
        }

        if (! $admin->isActive()) {
            throw ValidationException::withMessages([
                'email' => [__('greeate::messages.account_inactive')],
            ]);
        }

        $this->adminService->recordLogin($admin);
        $token = $admin->createToken('greeate-api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'admin' => new AdminResource($admin->load('roles')),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => __('greeate::messages.logged_out')]);
    }

    public function me(Request $request)
    {
        return new AdminResource($request->user()->load('roles', 'permissions'));
    }
}
