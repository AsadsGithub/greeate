@if ($paginator->hasPages())
<nav class="flex items-center justify-between">
    <p class="text-sm text-gray-500">
        {{ __('greeate::pagination.showing', ['from' => $paginator->firstItem(), 'to' => $paginator->lastItem(), 'total' => $paginator->total()]) }}
    </p>
    <div class="flex gap-1">
        @if ($paginator->onFirstPage())
        <span class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-400 text-sm">&laquo;</span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm hover:bg-gray-50">&laquo;</a>
        @endif
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if ($page == $paginator->currentPage())
            <span class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white text-sm">{{ $page }}</span>
            @else
            <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm hover:bg-gray-50">{{ $page }}</a>
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm hover:bg-gray-50">&raquo;</a>
        @else
        <span class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-400 text-sm">&raquo;</span>
        @endif
    </div>
</nav>
@endif
