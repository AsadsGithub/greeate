<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ greeate_direction() }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: true }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('greeate.name')) - Admin</title>
    @vite(['resources/css/greeate.css', 'resources/js/greeate.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 antialiased" x-cloak>
    <div class="flex min-h-screen">
        @include('greeate::components.sidebar')
        <div class="flex-1 flex flex-col min-w-0">
            @include('greeate::components.topbar')
            <main class="flex-1 p-6 overflow-auto">
                @include('greeate::components.breadcrumbs')
                @include('greeate::components.alerts')
                @yield('content')
            </main>
        </div>
    </div>
    @include('greeate::components.toast')
    @stack('scripts')
</body>
</html>
