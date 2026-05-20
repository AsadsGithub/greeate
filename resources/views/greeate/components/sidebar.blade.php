<aside class="w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 flex flex-col transition-all duration-300"
       :class="{ 'w-20': !sidebarOpen, 'w-64': sidebarOpen }">
    <div class="h-16 flex items-center px-4 border-b border-gray-200 dark:border-gray-800">
        <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent" x-show="sidebarOpen">Greeate</span>
    </div>
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
        <a href="{{ route('greeate.admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.dashboard') ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
            <span x-show="sidebarOpen">{{ __('greeate::nav.dashboard') }}</span>
        </a>
        @greeateCan('admins.view')
        <a href="{{ route('greeate.admin.admins.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.admins.*') ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
            <span x-show="sidebarOpen">{{ __('greeate::nav.admins') }}</span>
        </a>
        @endgreeateCan
        @greeateCan('roles.view')
        <a href="{{ route('greeate.admin.roles.index') }}" class="sidebar-link {{ request()->routeIs('greeate.admin.roles.*') ? 'active' : '' }}">
            <span x-show="sidebarOpen">{{ __('greeate::nav.roles') }}</span>
        </a>
        @endgreeateCan
        @greeateCan('banners.view')
        <a href="{{ route('greeate.admin.banners.index') }}" class="sidebar-link">
            <span x-show="sidebarOpen">{{ __('greeate::nav.banners') }}</span>
        </a>
        @endgreeateCan
        @greeateCan('faqs.view')
        <a href="{{ route('greeate.admin.faqs.index') }}" class="sidebar-link">
            <span x-show="sidebarOpen">{{ __('greeate::nav.faqs') }}</span>
        </a>
        @endgreeateCan
        @greeateCan('languages.view')
        <a href="{{ route('greeate.admin.languages.index') }}" class="sidebar-link">
            <span x-show="sidebarOpen">{{ __('greeate::nav.languages') }}</span>
        </a>
        @endgreeateCan
        @greeateCan('site-settings.general.view')
        <a href="{{ route('greeate.admin.settings.index', 'general') }}" class="sidebar-link">
            <span x-show="sidebarOpen">{{ __('greeate::nav.settings') }}</span>
        </a>
        @endgreeateCan
        @greeateCan('activity-logs.view')
        <a href="{{ route('greeate.admin.activity-logs.index') }}" class="sidebar-link">
            <span x-show="sidebarOpen">{{ __('greeate::nav.activity_logs') }}</span>
        </a>
        @endgreeateCan
    </nav>
</aside>
