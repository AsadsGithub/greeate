@extends('greeate::layouts.auth')
@section('title', 'Login')
@section('content')
<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-800">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('greeate::nav.login') ?? 'Sign In' }}</h2>
        <p class="text-sm text-gray-500 mt-2">{{ greeate_setting('site_name', 'Greeate') }} Admin Panel</p>
    </div>
    <form method="POST" action="{{ route('greeate.login.store') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">{{ __('greeate::fields.email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-input w-full" required autofocus>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">{{ __('greeate::fields.password') }}</label>
                <input type="password" name="password" class="form-input w-full" required>
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                    Remember me
                </label>
                <a href="{{ route('greeate.password.request') }}" class="text-sm text-indigo-600 hover:underline">Forgot password?</a>
            </div>
            <button type="submit" class="btn-primary w-full">Sign In</button>
        </div>
    </form>
</div>
@endsection
