@extends('greeate::layouts.admin')
@section('title', __('greeate::nav.dashboard'))

@section('breadcrumbs')
@include('greeate::components.breadcrumbs', ['breadcrumbs' => [__('greeate::nav.dashboard') => route('greeate.admin.dashboard')]])
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight">{{ __('greeate::nav.dashboard') }}</h1>
    <p class="mt-1 text-muted-foreground">{{ __('greeate::messages.welcome_back') }}</p>
</div>

<div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="stat-card">
        <p class="text-sm text-muted-foreground">{{ __('greeate::stats.total_admins') }}</p>
        <p class="mt-2 text-3xl font-bold">{{ $stats['admins'] ?? 0 }}</p>
    </div>
    <div class="stat-card">
        <p class="text-sm text-muted-foreground">{{ __('greeate::stats.new_contacts') }}</p>
        <p class="mt-2 text-3xl font-bold">{{ $stats['contacts'] ?? 0 }}</p>
    </div>
    <div class="stat-card">
        <p class="text-sm text-muted-foreground">{{ __('greeate::stats.notifications') }}</p>
        <p class="mt-2 text-3xl font-bold">{{ $stats['notifications'] ?? 0 }}</p>
    </div>
    <div class="stat-card">
        <p class="text-sm text-muted-foreground">{{ __('greeate::stats.system_status') }}</p>
        <p class="mt-2 text-3xl font-bold text-green-600">{{ __('greeate::stats.online') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    <div class="card">
        <h2 class="mb-4 text-lg font-semibold">{{ __('greeate::stats.recent_activities') }}</h2>
        <div class="space-y-3">
            @forelse($stats['activities'] ?? [] as $activity)
            <div class="flex gap-3 text-sm">
                <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-primary"></span>
                <div>
                    <p>{{ $activity->description }}</p>
                    <p class="text-xs text-muted-foreground">{{ $activity->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-muted-foreground">{{ __('greeate::messages.no_records') }}</p>
            @endforelse
        </div>
    </div>
    <div class="card">
        <h2 class="mb-4 text-lg font-semibold">{{ __('greeate::stats.latest_contacts') }}</h2>
        @forelse($stats['recent_contacts'] ?? [] as $contact)
        <div class="flex justify-between border-b border-border py-2 text-sm last:border-0">
            <span>{{ $contact->name }}</span>
            <span class="text-muted-foreground">{{ $contact->created_at->diffForHumans() }}</span>
        </div>
        @empty
        <p class="text-sm text-muted-foreground">{{ __('greeate::messages.no_records') }}</p>
        @endforelse
    </div>
</div>
@endsection
