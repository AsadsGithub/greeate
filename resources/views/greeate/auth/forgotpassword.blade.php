@extends('greeate::layouts.auth')
@section('title', __('greeate::auth.forgot_password'))

@section('content')
<div class="text-center mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ __('greeate::auth.forgot_password') }}</h1>
    <p class="mt-2 text-slate-600 dark:text-slate-300">{{ __('greeate::auth.forgot_subtitle') }}</p>
</div>
<div class="auth-card">
    <form method="POST" action="#" class="space-y-5">
        @csrf
        <div>
            <label class="auth-label">{{ __('greeate::fields.email') }}</label>
            <input type="email" name="email" class="auth-input" required>
        </div>
        <button type="submit" class="btn-auth">{{ __('greeate::auth.send_reset_link') }}</button>
    </form>
    <p class="mt-6 text-center text-sm">
        <a href="{{ route('greeate.login') }}" class="font-medium text-primary">{{ __('greeate::auth.back_to_login') }}</a>
    </p>
</div>
@endsection
