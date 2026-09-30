@extends('layouts.auth')

@section('title', 'Login | Library Management System')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900">
            Welcome back
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Sign in to access your library account.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">
            <div class="flex gap-3">
                <svg
                    class="w-5 h-5 text-red-500 shrink-0 mt-0.5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>

                <div>
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-red-700">
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if (session('status'))
        <div class="mb-6 rounded-xl bg-green-50 border border-green-200 p-4">
            <p class="text-sm text-green-700">
                {{ session('status') }}
            </p>
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">

        @csrf

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
                autofocus
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
            <div class="flex items-center justify-between mb-2">
                <label
                    for="password"
                    class="block text-sm font-medium text-slate-700"
                >
                    Password
                </label>

                <a
                    href="#"
                    class="text-sm font-medium text-primary-600 hover:text-primary-700"
                >
                    Forgot password?
                </a>
            </div>

            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 placeholder-slate-400 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-100"
            >

            @error('password')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex items-center">
            <input
                type="checkbox"
                id="remember"
                name="remember"
                class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500"
            >

            <label
                for="remember"
                class="ml-2 text-sm text-slate-600"
            >
                Remember me
            </label>
        </div>

        <button
            type="submit"
            class="w-full rounded-xl bg-primary-600 px-4 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-200"
        >
            Sign in
        </button>

    </form>

    <div class="relative my-7">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-200"></div>
        </div>

        <div class="relative flex justify-center">
            <span class="bg-white px-4 text-sm text-slate-400">
                New to the library?
            </span>
        </div>
    </div>

    <a
        href="{{ route('register') }}"
        class="block w-full rounded-xl border border-slate-300 px-4 py-3.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
    >
        Create an account
    </a>

</div>

@endsection
