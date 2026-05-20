<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
    </button>
    <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="p-3 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <span class="font-medium text-sm">{{ __('greeate::nav.notifications') }}</span>
            <a href="{{ route('greeate.admin.notifications.index') }}" class="text-xs text-indigo-600">{{ __('greeate::actions.view_all') }}</a>
        </div>
        <div class="max-h-64 overflow-y-auto p-2 text-sm text-gray-500 text-center py-6">
            {{ __('greeate::messages.no_notifications') }}
        </div>
    </div>
</div>
