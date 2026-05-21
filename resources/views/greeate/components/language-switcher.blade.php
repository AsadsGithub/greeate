@php
    $variant = $variant ?? 'default';
    $languages = app(\Greeate\Greeate\Services\TranslationService::class)->getActiveLanguages();
    $current = app()->getLocale();
@endphp
<div class="flex items-center gap-1 rounded-lg {{ $variant === 'auth' ? 'bg-white/10 p-1 backdrop-blur' : 'bg-muted p-1' }}">
    @foreach($languages as $lang)
        <form method="POST" action="{{ route('greeate.language.switch', $lang->code) }}" class="inline">
            @csrf
            <button type="submit"
                    class="lang-btn {{ $current === $lang->code ? 'active' : '' }} {{ $variant === 'admin' ? '!text-foreground' : '' }}">
                {{ strtoupper($lang->code) }}
            </button>
        </form>
    @endforeach
</div>
