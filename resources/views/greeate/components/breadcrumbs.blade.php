@if(isset($breadcrumbs) && count($breadcrumbs))
<nav class="mb-4 flex items-center gap-2 text-sm text-gray-500">
    @foreach($breadcrumbs as $label => $url)
        @if(!$loop->last)
            <a href="{{ $url }}" class="hover:text-indigo-600">{{ $label }}</a>
            <span>/</span>
        @else
            <span class="text-gray-900 dark:text-white font-medium">{{ $label }}</span>
        @endif
    @endforeach
</nav>
@endif
