@extends('greeate::layouts.admin')
@section('content')
<div class="max-w-2xl"><h1 class="text-2xl font-bold mb-6">Show Banners</h1>
<form method="POST" action="#">@csrf<button class="btn-primary mt-4">Save</button></form></div>
@endsection