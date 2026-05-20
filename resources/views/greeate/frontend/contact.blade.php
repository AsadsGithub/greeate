@extends('greeate::layouts.frontend')
@section('content')
<section class="py-16 max-w-xl mx-auto"><h1 class="text-3xl font-bold mb-6">Contact Us</h1><form method="POST" action="{{ route('greeate.contact.store') }}">@csrf<div class="space-y-4"><input name="name" class="form-input w-full" placeholder="Name" required><input name="email" type="email" class="form-input w-full" placeholder="Email" required><textarea name="message" class="form-input w-full" rows="4" required></textarea><button class="btn-primary w-full">Send</button></div></form></section>
@endsection
