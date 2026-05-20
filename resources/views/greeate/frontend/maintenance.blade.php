@extends('greeate::layouts.frontend')
@section('content')
<section class="min-h-screen flex items-center justify-center"><div class="text-center"><h1 class="text-4xl font-bold">{{ $settings->title ?? 'Maintenance' }}</h1><p class="mt-4">{{ $settings->description ?? 'We will be back soon.' }}</p></div></section>
@endsection
