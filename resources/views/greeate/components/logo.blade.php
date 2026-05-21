@php
    $siteName = greeate_setting('site_name', config('greeate.name', 'Greeate'));
    $logo = greeate_setting('site_logo');
    $variant = $variant ?? 'default';
    $textClass = $variant === 'auth'
        ? 'text-xl font-bold text-slate-800 dark:text-slate-100'
        : 'text-lg font-bold text-sidebar-foreground';
@endphp
@if($logo)
    <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-8 w-8 rounded-lg object-contain">
@else
    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary-gradient text-sm font-bold text-white">
        {{ strtoupper(substr($siteName, 0, 1)) }}
    </div>
@endif
<span class="{{ $textClass }}">{{ $siteName }}</span>
