<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ greeate_direction() }}"
      x-data="{ darkMode: localStorage.getItem('greeate-dark') === 'true' }"
      :class="{ 'dark': darkMode }"
      x-cloak>
<head>
    <title>@yield('title', __('greeate::auth.log_in')) - {{ greeate_setting('site_name', config('greeate.name')) }}</title>
    @include('greeate::layouts.partials.head')
    @stack('styles')
</head>
<body class="min-h-screen bg-auth-gradient antialiased">
    {{-- Top bar: logo + language --}}
    <div class="fixed top-0 left-0 right-0 z-20 flex items-center justify-between p-6">
        <a href="{{ route('greeate.home') }}" class="flex items-center gap-3 {{ greeate_is_rtl() ? 'flex-row-reverse' : '' }}">
            @include('greeate::components.logo', ['variant' => 'auth'])
        </a>
        @include('greeate::components.language-switcher', ['variant' => 'auth'])
    </div>

    <div class="flex min-h-screen items-center justify-center p-6 pt-24">
        <div class="w-full max-w-md">
            @yield('content')
        </div>
    </div>

    @include('greeate::components.toast')
    @stack('scripts')
</body>
</html>
