<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ greeate_direction() }}"
      x-data="{ darkMode: localStorage.getItem('greeate-dark') === 'true' }"
      :class="{ 'dark': darkMode }">
<head>
    <title>@yield('title', greeate_setting('meta_title', greeate_setting('site_name', 'Greeate')))</title>
    <meta name="description" content="{{ greeate_setting('meta_description', '') }}">
    @include('greeate::layouts.partials.head')
    @stack('styles')
</head>
<body class="min-h-screen bg-background text-foreground antialiased">
    @include('greeate::components.frontend-nav')
    <main>@yield('content')</main>
    @include('greeate::components.frontend-footer')
    @include('greeate::components.toast')
    @stack('scripts')
</body>
</html>
