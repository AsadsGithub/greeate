<aside class="greeate-sidebar -translate-x-full lg:translate-x-0"
       :class="{ '!translate-x-0': mobileSidebar, 'collapsed': !sidebarOpen }">
    <div class="sidebar-brand">
        <a href="{{ route('greeate.admin.dashboard') }}" class="flex items-center gap-3 overflow-hidden">
            @include('greeate::components.logo')
        </a>
    </div>

    <nav class="sidebar-nav">
        <div>
            <p class="sidebar-group-title" x-show="sidebarOpen">{{ __('greeate::nav.platform') }}</p>
            @greeateCan('dashboard.view')
            <a href="{{ route('greeate.admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('greeate.admin.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span x-show="sidebarOpen">{{ __('greeate::nav.dashboard') }}</span>
            </a>
            @endgreeateCan
        </div>

        <div>
            <p class="sidebar-group-title" x-show="sidebarOpen">{{ __('greeate::nav.user_management') }}</p>
            @greeateCan('admins.view')
            <a href="{{ route('greeate.admin.admins.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.admins.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
                <span x-show="sidebarOpen">{{ __('greeate::nav.admins') }}</span>
            </a>
            @endgreeateCan
            @greeateCan('roles.view')
            <a href="{{ route('greeate.admin.roles.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.roles.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span x-show="sidebarOpen">{{ __('greeate::nav.roles') }}</span>
            </a>
            @endgreeateCan
            @greeateCan('permissions.view')
            <a href="{{ route('greeate.admin.permissions.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.permissions.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                <span x-show="sidebarOpen">{{ __('greeate::nav.permissions') }}</span>
            </a>
            @endgreeateCan
        </div>

        <div>
            <p class="sidebar-group-title" x-show="sidebarOpen">{{ __('greeate::nav.content') }}</p>
            @greeateCan('banners.view')
            <a href="{{ route('greeate.admin.banners.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.banners.*') ? 'active' : '' }}">
                <span x-show="sidebarOpen">{{ __('greeate::nav.banners') }}</span>
            </a>
            @endgreeateCan
            @greeateCan('faqs.view')
            <a href="{{ route('greeate.admin.faqs.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.faqs.*') ? 'active' : '' }}">
                <span x-show="sidebarOpen">{{ __('greeate::nav.faqs') }}</span>
            </a>
            @endgreeateCan
            @greeateCan('static-pages.view')
            <a href="{{ route('greeate.admin.static-pages.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.static-pages.*') ? 'active' : '' }}">
                <span x-show="sidebarOpen">{{ __('greeate::nav.static_pages') }}</span>
            </a>
            @endgreeateCan
            @greeateCan('languages.view')
            <a href="{{ route('greeate.admin.languages.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.languages.*') ? 'active' : '' }}">
                <span x-show="sidebarOpen">{{ __('greeate::nav.languages') }}</span>
            </a>
            @endgreeateCan
        </div>

        <div>
            <p class="sidebar-group-title" x-show="sidebarOpen">{{ __('greeate::nav.notifications') }}</p>
            @greeateCan('notifications.view')
            <a href="{{ route('greeate.admin.notifications.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.notifications.*') ? 'active' : '' }}">
                <span x-show="sidebarOpen">{{ __('greeate::nav.notifications') }}</span>
            </a>
            @endgreeateCan
            @greeateCan('broadcasts.view')
            <a href="{{ route('greeate.admin.broadcasts.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.broadcasts.*') ? 'active' : '' }}">
                <span x-show="sidebarOpen">{{ __('greeate::nav.broadcasts') }}</span>
            </a>
            @endgreeateCan
            @greeateCan('contact-messages.view')
            <a href="{{ route('greeate.admin.contact-messages.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.contact-messages.*') ? 'active' : '' }}">
                <span x-show="sidebarOpen">{{ __('greeate::nav.contact_messages') }}</span>
            </a>
            @endgreeateCan
        </div>

        <div>
            <p class="sidebar-group-title" x-show="sidebarOpen">{{ __('greeate::nav.settings') }}</p>
            @greeateCan('site-settings.general.view')
            <a href="{{ route('greeate.admin.settings.index', 'general') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.settings.*') ? 'active' : '' }}">
                <span x-show="sidebarOpen">{{ __('greeate::nav.settings') }}</span>
            </a>
            @endgreeateCan
            @greeateCan('activity-logs.view')
            <a href="{{ route('greeate.admin.activity-logs.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.activity-logs.*') ? 'active' : '' }}">
                <span x-show="sidebarOpen">{{ __('greeate::nav.activity_logs') }}</span>
            </a>
            @endgreeateCan
            <a href="{{ route('greeate.admin.profile.edit') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.profile.*') ? 'active' : '' }}">
                <span x-show="sidebarOpen">{{ __('greeate::nav.profile') }}</span>
            </a>
        </div>
    </nav>

    <div class="border-t border-sidebar-border p-3">
        <div class="flex items-center gap-3 rounded-lg bg-sidebar-accent/50 p-2" x-show="sidebarOpen">
            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-primary-gradient text-sm font-bold text-white">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium">{{ auth()->user()->name ?? '' }}</p>
                <p class="truncate text-xs text-muted-foreground">{{ auth()->user()->email ?? '' }}</p>
            </div>
        </div>
    </div>
</aside>
