<nav class="border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
        <a href="{{ route('greeate.home') }}" class="text-xl font-bold text-indigo-600">{{ greeate_setting('site_name', 'Greeate') }}</a>
        <div class="flex items-center gap-6 text-sm">
            <a href="{{ route('greeate.home') }}">Home</a>
            <a href="{{ route('greeate.contact') }}">Contact</a>
            <a href="{{ route('greeate.page', 'privacy-policy') }}">Privacy</a>
            <a href="{{ route('greeate.login') }}">Login</a>
            @foreach(app(\Greeate\Greeate\Services\TranslationService::class)->getActiveLanguages() as $lang)
            <form method="POST" action="{{ route('greeate.language.switch', $lang->code) }}" class="inline">@csrf
                <button type="submit" class="{{ app()->getLocale() === $lang->code ? 'font-bold text-indigo-600' : '' }}">{{ $lang->code }}</button>
            </form>
            @endforeach
        </div>
    </div>
</nav>
