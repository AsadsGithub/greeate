<header class="sticky top-0 z-30 border-b border-border bg-card/80 backdrop-blur-md">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4">
        <a href="{{ route('greeate.home') }}" class="flex items-center gap-3">
            @include('greeate::components.logo')
        </a>
        <nav class="hidden items-center gap-6 text-sm font-medium md:flex">
            <a href="{{ route('greeate.home') }}" class="text-muted-foreground hover:text-primary">{{ __('greeate::nav.home') }}</a>
            <a href="{{ route('greeate.contact') }}" class="text-muted-foreground hover:text-primary">{{ __('greeate::nav.contact') }}</a>
            <a href="{{ route('greeate.page', 'privacy-policy') }}" class="text-muted-foreground hover:text-primary">{{ __('greeate::nav.privacy') }}</a>
        </nav>
        <div class="flex items-center gap-3">
            @include('greeate::components.language-switcher')
            <a href="{{ route('greeate.login') }}" class="btn-primary btn-sm">{{ __('greeate::auth.log_in') }}</a>
        </div>
    </div>
</header>
