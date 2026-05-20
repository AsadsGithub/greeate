<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ greeate_direction() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', greeate_setting('meta_title', 'Greeate'))</title>
    <meta name="description" content="{{ greeate_setting('meta_description', '') }}">
    @vite(['resources/css/greeate.css', 'resources/js/greeate.js'])
</head>
<body class="bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100">
    @include('greeate::components.frontend-nav')
    <main>@yield('content')</main>
    @include('greeate::components.frontend-footer')
</body>
</html>
