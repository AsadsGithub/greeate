@extends('greeate::layouts.frontend')
@section('content')
<article class="prose max-w-4xl mx-auto py-16"><h1>{{ $page->title ?? 'Page' }}</h1><div>{!! $page->content ?? '' !!}</div></article>
@endsection
