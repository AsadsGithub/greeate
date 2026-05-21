@extends('greeate::layouts.auth')
@section('title', __('greeate::auth.reset_password'))

@section('content')
<div class="text-center mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ __('greeate::auth.reset_password') }}</h1>
</div>
<div class="auth-card">
    <form method="POST" action="#" class="space-y-5">
        @csrf
        <div>
            <label class="auth-label">{{ __('greeate::fields.email') }}</label>
            <input type="email" name="email" class="auth-input" required>
        </div>
        <div>
            <label class="auth-label">{{ __('greeate::fields.password') }}</label>
            <input type="password" name="password" class="auth-input" required>
        </div>
        <div>
            <label class="auth-label">{{ __('greeate::auth.confirm_password') }}</label>
            <input type="password" name="password_confirmation" class="auth-input" required>
        </div>
        <button type="submit" class="btn-auth">{{ __('greeate::auth.reset_password') }}</button>
    </form>
</div>
@endsection
