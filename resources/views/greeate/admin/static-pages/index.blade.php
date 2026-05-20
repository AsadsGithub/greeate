@extends('greeate::layouts.admin')
@section('title', 'Manage')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Static Pages</h1>
    <a href="{{ route('greeate.admin.static-pages.create') }}" class="btn-primary">Create</a>
</div>
<div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800/50"><tr><th class="px-4 py-3 text-left">ID</th><th class="px-4 py-3 text-left">Name</th><th class="px-4 py-3 text-right">Actions</th></tr></thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse($items as $item)
            <tr><td class="px-4 py-3">{{ $item->id }}</td><td class="px-4 py-3">{{ $item->name ?? $item->title ?? $item->email ?? '-' }}</td>
            <td class="px-4 py-3 text-right"><a href="{{ route('greeate.admin.static-pages.edit', $item) }}" class="text-indigo-600">Edit</a></td></tr>
            @empty<tr><td colspan="3" class="px-4 py-8 text-center text-gray-500">No records</td></tr>@endforelse
        </tbody>
    </table>
    {{ $items->links('greeate::components.pagination') }}
</div>
@endsection