@props(['items', 'columns', 'actions' => true, 'bulkActions' => false])

<div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden" x-data="{ selected: [] }">
    @if($bulkActions)
    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3" x-show="selected.length > 0">
        <span class="text-sm text-gray-500" x-text="selected.length + ' selected'"></span>
        <button class="btn-danger btn-sm">{{ __('greeate::actions.bulk_delete') }}</button>
    </div>
    @endif
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800/50">
                <tr>
                    @if($bulkActions)
                    <th class="px-4 py-3 w-10"><input type="checkbox" @change="selected = $event.target.checked ? [...document.querySelectorAll('[data-row-id]')].map(el => el.dataset.rowId) : []"></th>
                    @endif
                    @foreach($columns as $column)
                    <th class="px-4 py-3 text-left font-medium text-gray-600 dark:text-gray-400">{{ $column['label'] }}</th>
                    @endforeach
                    @if($actions)<th class="px-4 py-3 text-right">{{ __('greeate::actions.actions') }}</th>@endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse($items as $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                    @if($bulkActions)
                    <td class="px-4 py-3"><input type="checkbox" data-row-id="{{ $item->id }}" x-model="selected" value="{{ $item->id }}"></td>
                    @endif
                    {{ $slot($item) }}
                    @if($actions)
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            {{ $actionsSlot ?? '' }}
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="20" class="px-4 py-12 text-center text-gray-500">
                        @include('greeate::components.empty-state')
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($items, 'links'))
    <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-800">
        {{ $items->withQueryString()->links('greeate::components.pagination') }}
    </div>
    @endif
</div>
