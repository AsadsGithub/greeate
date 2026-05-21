<?php

namespace Greeate\Greeate\Http\Controllers\Auth;

use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends BaseController
{
    public function __construct(protected AdminService $adminService) {}

    public function index()
    {
        return $this->greeatePage('greeate/auth/login', [
            'canResetPassword' => true,
            'status' => session('status'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $key = 'greeate-login:'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => [__('greeate::messages.too_many_attempts')],
            ]);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || ! \Illuminate\Support\Facades\Hash::check($request->password, $admin->password)) {
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages([
                'email' => [__('greeate::messages.invalid_credentials')],
            ]);
        }

        if (! $admin->isActive()) {
            throw ValidationException::withMessages([
                'email' => [__('greeate::messages.account_inactive')],
            ]);
        }

        Auth::login($admin, $request->boolean('remember'));
        $this->adminService->recordLogin($admin);
        RateLimiter::clear($key);

        return redirect()->intended(route('greeate.admin.dashboard'));
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('greeate.login');
    }
}
