@extends('greeate::layouts.auth')
@section('title', __('greeate::auth.log_in'))

@section('content')
<div class="text-center mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ __('greeate::auth.log_in') }}</h1>
    <p class="mt-2 text-slate-600 dark:text-slate-300">{{ __('greeate::auth.login_subtitle') }}</p>
</div>

<div class="auth-card">
    <form method="POST" action="{{ route('greeate.login.store') }}" class="space-y-6">
        @csrf
        <div>
            <label for="email" class="auth-label">{{ __('greeate::fields.email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   autocomplete="email" class="auth-input" placeholder="admin@example.com">
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="password" class="auth-label">{{ __('greeate::fields.password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="auth-input" placeholder="••••••••">
            @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-center justify-between {{ greeate_is_rtl() ? 'flex-row-reverse' : '' }}">
            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-primary focus:ring-primary">
                {{ __('greeate::auth.remember_me') }}
            </label>
            <a href="{{ route('greeate.password.request') }}" class="text-sm font-medium text-primary hover:opacity-80">
                {{ __('greeate::auth.forgot_password') }}
            </a>
        </div>
        <button type="submit" class="btn-auth">{{ __('greeate::auth.log_in') }}</button>
    </form>

    @if(config('greeate.auth.register_enabled'))
    <p class="mt-6 text-center text-sm text-slate-600 dark:text-slate-300">
        {{ __('greeate::auth.no_account') }}
        <a href="{{ route('greeate.register') }}" class="font-medium text-primary hover:opacity-80">{{ __('greeate::auth.create_account') }}</a>
    </p>
    @endif
</div>
@endsection
