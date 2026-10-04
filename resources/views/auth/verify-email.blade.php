@extends('layouts.auth')
@section('title', 'Verify email')
@section('content')
<div class="mx-auto max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <h1 class="text-xl font-bold text-slate-900">Verify your email</h1>
    <p class="mt-2 text-sm text-slate-500">We sent a link to {{ auth()->user()->email }}. Click it to continue.</p>
    <form method="POST" action="{{ route('verification.send') }}" class="mt-5">
        @csrf
        <button class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Resend link</button>
    </form>
</div>
@endsection