<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ greeate_direction() }}" x-data="{ darkMode: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Auth') - {{ greeate_setting('site_name', 'Greeate') }}</title>
    @vite(['resources/css/greeate.css', 'resources/js/greeate.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-950 dark:via-gray-900 dark:to-indigo-950 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        @yield('content')
    </div>
</body>
</html>
