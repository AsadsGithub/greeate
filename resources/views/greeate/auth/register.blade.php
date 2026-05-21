@extends('greeate::layouts.auth')
@section('title', __('greeate::auth.create_account'))

@section('content')
<div class="text-center mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ __('greeate::auth.create_account') }}</h1>
    <p class="mt-2 text-slate-600 dark:text-slate-300">{{ __('greeate::auth.register_subtitle') }}</p>
</div>
<div class="auth-card">
    <form method="POST" action="#" class="space-y-5">
        @csrf
        <div>
            <label class="auth-label">{{ __('greeate::fields.name') }}</label>
            <input type="text" name="name" class="auth-input" required>
        </div>
        <div>
            <label class="auth-label">{{ __('greeate::fields.email') }}</label>
            <input type="email" name="email" class="auth-input" required>
        </div>
        <div>
            <label class="auth-label">{{ __('greeate::fields.password') }}</label>
            <input type="password" name="password" class="auth-input" required>
        </div>
        <button type="submit" class="btn-auth">{{ __('greeate::auth.create_account') }}</button>
    </form>
    <p class="mt-6 text-center text-sm">
        <a href="{{ route('greeate.login') }}" class="font-medium text-primary">{{ __('greeate::auth.already_have_account') }}</a>
    </p>
</div>
@endsection
