@extends('greeate::layouts.admin')
@section('title', __('greeate::nav.profile'))
@section('content')
<x-greeate::card :title="__('greeate::nav.profile')">
    <form method="POST" action="{{ route('greeate.admin.profile.update') }}" class="max-w-xl space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">{{ __('greeate::fields.name') }}</label>
            <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="form-input w-full" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">{{ __('greeate::fields.email') }}</label>
            <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="form-input w-full" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">{{ __('greeate::fields.phone') }}</label>
            <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}" class="form-input w-full">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">{{ __('greeate::fields.password') }}</label>
            <input type="password" name="password" class="form-input w-full" placeholder="Leave blank to keep">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-input w-full">
        </div>
        <button type="submit" class="btn-primary">{{ __('greeate::actions.save') }}</button>
    </form>
</x-greeate::card>
@endsection
