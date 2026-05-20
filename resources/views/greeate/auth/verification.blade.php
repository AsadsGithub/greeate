@extends('greeate::layouts.auth')
@section('content')
<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-800">
<h2 class="text-2xl font-bold text-center mb-6">Verification</h2>
<form method="POST" action="#">@csrf
<input type="email" name="email" class="form-input w-full mb-4" placeholder="Email">
<input type="password" name="password" class="form-input w-full mb-4" placeholder="Password">
<button class="btn-primary w-full">Submit</button></form></div>
@endsection