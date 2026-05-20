<?php

namespace Greeate\Greeate\Http\Controllers\Frontend;

use Greeate\Greeate\Contracts\ContactMessageRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Notifications\ContactMessageReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends BaseController
{
    public function __construct(protected ContactMessageRepositoryInterface $repository) {}

    public function index()
    {
        return view('greeate::frontend.contact');
    }

    public function store(Request $request)
    {
        $key = 'contact-form:'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 10)) {
            return back()->with('error', __('greeate::messages.too_many_attempts'));
        }

        RateLimiter::hit($key, 60);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();
        $validated['status'] = 'new';

        $message = $this->repository->create($validated);

        $admins = Admin::role(config('greeate.super_admin_role', 'super-admin'))->get();
        Notification::send($admins, new ContactMessageReceived($message));

        return back()->with('success', __('greeate::messages.contact_sent'));
    }
}
