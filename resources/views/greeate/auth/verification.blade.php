@extends('greeate::layouts.auth')
@section('title', __('greeate::auth.verify_email'))

@section('content')
<div class="text-center mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ __('greeate::auth.verify_email') }}</h1>
    <p class="mt-2 text-slate-600 dark:text-slate-300">{{ __('greeate::auth.verify_subtitle') }}</p>
</div>
<div class="auth-card text-center">
    <form method="POST" action="#">
        @csrf
        <button type="submit" class="btn-auth">{{ __('greeate::auth.resend_verification') }}</button>
    </form>
</div>
@endsection
