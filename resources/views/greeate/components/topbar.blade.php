<header class="greeate-header">
    <div class="flex items-center gap-2">
        <button type="button" class="btn-icon lg:hidden" @click="mobileSidebar = !mobileSidebar" aria-label="Menu">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <button type="button" class="btn-icon hidden lg:inline-flex" @click="sidebarOpen = !sidebarOpen" aria-label="Toggle sidebar">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        @include('greeate::components.breadcrumbs')
    </div>

    <div class="flex items-center gap-2">
        <div class="relative hidden md:block">
            <svg class="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-muted-foreground {{ greeate_is_rtl() ? 'left-auto right-3' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="search" placeholder="{{ __('greeate::nav.search') }}" class="form-input w-56 pl-9 {{ greeate_is_rtl() ? 'pr-9 pl-3' : '' }}">
        </div>

        @include('greeate::components.language-switcher', ['variant' => 'admin'])

        <button type="button" class="btn-icon" @click="toggleDark()" aria-label="Theme">
            <svg x-show="!darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            <svg x-show="darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707.707m12.728 0l-.707-.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </button>

        @include('greeate::components.notifications-dropdown')

        <div x-data="{ open: false }" class="relative">
            <button type="button" @click="open = !open" class="flex items-center gap-2 rounded-lg p-1 hover:bg-accent">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-gradient text-sm font-medium text-white">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition
                 class="absolute right-0 z-50 mt-2 w-48 rounded-xl border border-border bg-card py-1 shadow-lg {{ greeate_is_rtl() ? 'left-0 right-auto' : '' }}">
                <a href="{{ route('greeate.admin.profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-accent">{{ __('greeate::nav.profile') }}</a>
                <form method="POST" action="{{ route('greeate.logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-left text-sm hover:bg-accent">{{ __('greeate::nav.logout') }}</button>
                </form>
            </div>
        </div>
    </div>
</header>
