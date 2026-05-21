<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ greeate_direction() }}"
      x-data="greeateAdmin()"
      :class="{ 'dark': darkMode }"
      x-cloak>
<head>
    <title>@yield('title', __('greeate::nav.dashboard')) - {{ greeate_setting('site_name', config('greeate.name')) }}</title>
    @include('greeate::layouts.partials.head')
    @stack('styles')
</head>
<body class="bg-background text-foreground"
      data-user-id="{{ auth()->id() }}"
      data-enable-web-push="{{ config('greeate.features.web_push') ? 'true' : 'false' }}">
    <div class="greeate-shell">
        <div x-show="mobileSidebar" x-transition class="greeate-sidebar-backdrop lg:hidden" @click="mobileSidebar = false"></div>

        @include('greeate::components.sidebar')

        <div class="greeate-main">
            @include('greeate::components.topbar')
            <main class="greeate-content">
                @hasSection('breadcrumbs')
                    @yield('breadcrumbs')
                @else
                    @include('greeate::components.breadcrumbs')
                @endif
                @include('greeate::components.alerts')
                @yield('content')
            </main>
        </div>
    </div>
    @include('greeate::components.toast')
    @stack('scripts')
</body>
</html>
