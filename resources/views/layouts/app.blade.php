<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Library') - Library Management
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

    @stack('styles')
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

<div class="min-h-screen">

    {{-- =========================================================
         NAVIGATION
    ========================================================== --}}

    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex h-16 items-center justify-between">

                {{-- Logo --}}
                <a href="{{ url('/') }}"
                   class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center
                                rounded-xl bg-blue-600 text-white shadow-sm">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>

                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

                        </svg>

                    </div>

                    <div class="hidden sm:block">

                        <p class="text-base font-bold tracking-tight text-slate-900">
                            Library
                        </p>

                        <p class="text-[11px] font-medium text-slate-400">
                            Management System
                        </p>

                    </div>

                </a>


                {{-- Desktop Navigation --}}
                <nav class="hidden items-center gap-1 md:flex">

                    {{-- Home --}}
                    <a href="{{ url('/') }}"
                       class="rounded-lg px-3 py-2 text-sm font-medium transition
                              {{ request()->is('/')
                                  ? 'bg-blue-50 text-blue-700'
                                  : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">

                        Home

                    </a>


                    {{-- Browse Books --}}
                    <a href="{{ url('/books') }}"
                       class="rounded-lg px-3 py-2 text-sm font-medium transition
                              {{ request()->is('books*')
                                  ? 'bg-blue-50 text-blue-700'
                                  : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">

                        Browse Books

                    </a>

                </nav>


                {{-- Right Side --}}
                <div class="flex items-center gap-3">

                    @auth

                        {{-- Desktop Profile --}}
                        <a href="{{ route('profile') }}"
                           class="hidden items-center gap-3 rounded-xl px-2 py-1.5
                                  transition hover:bg-slate-50 sm:flex">

                            <div class="text-right">

                                <p class="text-sm font-semibold text-slate-800">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-xs text-slate-400">
                                    My Profile
                                </p>

                            </div>


                            {{-- Avatar --}}
                            <div class="flex h-9 w-9 items-center justify-center
                                        rounded-full bg-blue-100
                                        text-sm font-bold text-blue-700">

                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                            </div>

                        </a>


                        {{-- Desktop Logout --}}
                        <form method="POST"
                              action="{{ route('logout') }}"
                              class="hidden sm:block">

                            @csrf

                            <button type="submit"
                                    class="rounded-lg px-3 py-2 text-sm font-medium
                                           text-slate-500 transition
                                           hover:bg-red-50 hover:text-red-600">

                                Logout

                            </button>

                        </form>

                    @else

                        {{-- Login --}}
                        <a href="{{ route('login') }}"
                           class="hidden rounded-lg px-3 py-2 text-sm font-semibold
                                  text-slate-600 transition
                                  hover:bg-slate-100 hover:text-slate-900 sm:block">

                            Login

                        </a>


                        {{-- Register --}}
                        <a href="{{ route('register') }}"
                           class="rounded-lg bg-blue-600 px-4 py-2 text-sm
                                  font-semibold text-white shadow-sm
                                  transition hover:bg-blue-700">

                            Create Account

                        </a>

                    @endauth


                    {{-- Mobile Menu Button --}}
                    <button type="button"
                            onclick="toggleMobileMenu()"
                            class="inline-flex h-10 w-10 items-center justify-center
                                   rounded-lg text-slate-600 hover:bg-slate-100
                                   md:hidden">

                        {{-- Open Icon --}}
                        <svg id="menu-open-icon"
                             class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <path d="M4 6h16"/>
                            <path d="M4 12h16"/>
                            <path d="M4 18h16"/>

                        </svg>


                        {{-- Close Icon --}}
                        <svg id="menu-close-icon"
                             class="hidden h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <path d="M6 6l12 12"/>
                            <path d="M18 6 6 18"/>

                        </svg>

                    </button>

                </div>

            </div>


            {{-- =====================================================
                 MOBILE NAVIGATION
            ====================================================== --}}

            <div id="mobile-menu"
                 class="hidden border-t border-slate-100 py-4 md:hidden">

                <nav class="space-y-1">

                    {{-- Home --}}
                    <a href="{{ url('/') }}"
                       class="block rounded-lg px-3 py-2.5 text-sm font-medium
                              {{ request()->is('/')
                                  ? 'bg-blue-50 text-blue-700'
                                  : 'text-slate-600 hover:bg-slate-100' }}">

                        Home

                    </a>


                    {{-- Browse Books --}}
                    <a href="{{ url('/books') }}"
                       class="block rounded-lg px-3 py-2.5 text-sm font-medium
                              {{ request()->is('books*')
                                  ? 'bg-blue-50 text-blue-700'
                                  : 'text-slate-600 hover:bg-slate-100' }}">

                        Browse Books

                    </a>


                    @auth

                        <div class="my-3 border-t border-slate-100"></div>


                        {{-- Mobile User Information --}}
                        <div class="flex items-center gap-3 px-3 py-2">

                            {{-- Avatar --}}
                            <div class="flex h-9 w-9 items-center justify-center
                                        rounded-full bg-blue-100
                                        text-sm font-bold text-blue-700">

                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                            </div>


                            <div>

                                <p class="text-sm font-semibold text-slate-800">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-xs text-slate-400">
                                    {{ auth()->user()->email }}
                                </p>

                            </div>

                        </div>


                        {{-- Mobile Profile --}}
                        <a href="{{ route('profile') }}"
                           class="block rounded-lg px-3 py-2.5 text-sm font-medium
                                  text-slate-600 hover:bg-slate-100">

                            My Profile

                        </a>


                        {{-- Mobile Logout --}}
                        <form method="POST"
                              action="{{ route('logout') }}"
                              class="mt-1">

                            @csrf

                            <button type="submit"
                                    class="w-full rounded-lg px-3 py-2.5 text-left
                                           text-sm font-medium text-red-600
                                           hover:bg-red-50">

                                Logout

                            </button>

                        </form>

                    @else

                        <div class="my-3 border-t border-slate-100"></div>


                        {{-- Mobile Login --}}
                        <a href="{{ route('login') }}"
                           class="block rounded-lg px-3 py-2.5 text-sm font-medium
                                  text-slate-600 hover:bg-slate-100">

                            Login

                        </a>


                        {{-- Mobile Register --}}
                        <a href="{{ route('register') }}"
                           class="mt-1 block rounded-lg bg-blue-600 px-3 py-2.5
                                  text-center text-sm font-semibold text-white
                                  hover:bg-blue-700">

                            Create Account

                        </a>

                    @endauth

                </nav>

            </div>

        </div>

    </header>


    {{-- =========================================================
         FLASH MESSAGES
    ========================================================== --}}

    <div class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">

        {{-- Success --}}
        @if (session('success'))

            <div class="flex items-start gap-3 rounded-xl border border-emerald-200
                        bg-emerald-50 px-4 py-3 text-sm text-emerald-800">

                <svg class="mt-0.5 h-5 w-5 shrink-0"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <path d="M20 6 9 17l-5-5"/>

                </svg>

                <p>
                    {{ session('success') }}
                </p>

            </div>

        @endif


        {{-- Error --}}
        @if (session('error'))

            <div class="flex items-start gap-3 rounded-xl border border-red-200
                        bg-red-50 px-4 py-3 text-sm text-red-800">

                <svg class="mt-0.5 h-5 w-5 shrink-0"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <circle cx="12" cy="12" r="9"/>

                    <path d="m15 9-6 6"/>
                    <path d="m9 9 6 6"/>

                </svg>

                <p>
                    {{ session('error') }}
                </p>

            </div>

        @endif


        {{-- Validation Errors --}}
        @if ($errors->any())

            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3">

                <div class="flex items-start gap-3">

                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-600"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">

                        <circle cx="12" cy="12" r="9"/>

                        <path d="m15 9-6 6"/>
                        <path d="m9 9 6 6"/>

                    </svg>


                    <div>

                        <p class="text-sm font-semibold text-red-800">
                            Please check the following:
                        </p>

                        <ul class="mt-1 list-inside list-disc text-sm text-red-700">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif

    </div>


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main class="mx-auto min-h-[calc(100vh-16rem)] max-w-7xl px-4 py-8
                 sm:px-6 lg:px-8">

        @yield('content')

    </main>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <footer class="border-t border-slate-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center
                        sm:justify-between">

                {{-- Footer Branding --}}
                <div>

                    <div class="flex items-center gap-2">

                        <div class="flex h-8 w-8 items-center justify-center
                                    rounded-lg bg-blue-600 text-white">

                            <svg class="h-4 w-4"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">

                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>

                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

                            </svg>

                        </div>

                        <span class="font-semibold text-slate-900">
                            Library Management
                        </span>

                    </div>


                    <p class="mt-2 text-sm text-slate-500">
                        Discover, borrow and manage your books.
                    </p>

                </div>


                {{-- Copyright --}}
                <div class="text-sm text-slate-400">

                    &copy; {{ date('Y') }} Library Management System

                </div>

            </div>

        </div>

    </footer>

</div>


{{-- =============================================================
     MOBILE MENU SCRIPT
============================================================== --}}

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('menu-open-icon');
        const closeIcon = document.getElementById('menu-close-icon');

        menu.classList.toggle('hidden');
        openIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    }
</script>


@stack('scripts')

</body>
</html>