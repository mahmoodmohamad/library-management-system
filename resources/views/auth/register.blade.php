@extends('layouts.auth')

@section('title', 'Create Account | Library Management System')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900">
            Create your account
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Register to access the library system.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">
            <div class="space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-700">
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="space-y-5">

        @csrf

        <div>
            <label
                for="name"
                class="block text-sm font-medium text-slate-700 mb-2"
            >
                Full name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="John Doe"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 placeholder-slate-400 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-100"
            >

            @error('name')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label
                for="email"
                class="block text-sm font-medium text-slate-700 mb-2"
            >
                Email address
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
                placeholder="you@example.com"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 placeholder-slate-400 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-100"
            >

            @error('email')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label
                for="password"
                class="block text-sm font-medium text-slate-700 mb-2"
            >
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="Create a password"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 placeholder-slate-400 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-100"
            >

            @error('password')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label
                for="password_confirmation"
                class="block text-sm font-medium text-slate-700 mb-2"
            >
                Confirm password
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Repeat your password"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 placeholder-slate-400 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-100"
            >
        </div>

        <button
            type="submit"
            class="w-full rounded-xl bg-primary-600 px-4 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-200"
        >
            Create account
        </button>

    </form>

    <p class="mt-7 text-center text-sm text-slate-500">
        Already have an account?

        <a
            href="{{ route('login') }}"
            class="font-semibold text-primary-600 hover:text-primary-700"
        >
            Sign in
        </a>
    </p>

</div>

@endsection