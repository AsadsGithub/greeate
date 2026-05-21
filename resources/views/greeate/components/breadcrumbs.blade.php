@if(isset($breadcrumbs) && count($breadcrumbs))
<nav class="breadcrumb-nav flex items-center gap-2 text-sm text-muted-foreground" aria-label="Breadcrumb">
    @foreach($breadcrumbs as $label => $url)
        @if(!$loop->last)
            <a href="{{ $url }}" class="hover:text-primary">{{ $label }}</a>
            <span class="text-muted-foreground/50">/</span>
        @else
            <span class="font-medium text-foreground">{{ $label }}</span>
        @endif
    @endforeach
</nav>
@endif
