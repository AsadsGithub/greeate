@props(['title' => null, 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6']) }}>
    @if($title)
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
        @if($subtitle)<p class="text-sm text-gray-500 mt-1">{{ $subtitle }}</p>@endif
    </div>
    @endif
    {{ $slot }}
</div>
