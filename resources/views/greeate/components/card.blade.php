<div {{ $attributes->merge(['class' => 'card']) }}>
    @if($title ?? false)
    <div class="card-header">
        <h3 class="text-lg font-semibold text-card-foreground">{{ $title }}</h3>
        @if($subtitle ?? false)
        <p class="mt-1 text-sm text-muted-foreground">{{ $subtitle }}</p>
        @endif
    </div>
    @endif
    {{ $slot }}
</div>
