@php
    $links = [
        ['label' => 'Home',         'href' => url('/'),      'active' => request()->is('/')],
        ['label' => 'Browse Books', 'href' => url('/books'), 'active' => request()->is('books*')],
    ];
    $initial = auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : null;
@endphp

<header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-16 items-center justify-between">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                    </svg>
                </div>
                <div class="hidden sm:block">
                    <p class="text-base font-bold tracking-tight text-slate-900">Library</p>
                    <p class="text-[11px] font-medium text-slate-400">Management System</p>
                </div>
            </a>

            {{-- Desktop navigation --}}
            <nav class="hidden items-center gap-1 md:flex">
                @foreach ($links as $link)
                    <a href="{{ $link['href'] }}"
                       @class([
                           'rounded-lg px-3 py-2 text-sm font-medium transition',
                           'bg-blue-50 text-blue-700' => $link['active'],
                           'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => ! $link['active'],
                       ])>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- Right side --}}
            <div class="flex items-center gap-3">

                @auth
                    <a href="{{ route('profile') }}"
                       class="hidden items-center gap-3 rounded-xl px-2 py-1.5 transition hover:bg-slate-50 sm:flex">
                        <div class="text-right">
                            <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400">My Profile</p>
                        </div>
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                            {{ $initial }}
                        </div>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                        @csrf
                        <button type="submit"
                                class="rounded-lg px-3 py-2 text-sm font-medium text-slate-500 transition
                                       hover:bg-red-50 hover:text-red-600">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition
                              hover:bg-slate-100 hover:text-slate-900 sm:block">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm
                              transition hover:bg-blue-700">
                        Create Account
                    </a>
                @endauth

                {{-- Mobile menu button --}}
                <button type="button" onclick="toggleMobileMenu()"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-slate-600
                               hover:bg-slate-100 md:hidden">
                    <svg id="menu-open-icon" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 6h16"/><path d="M4 12h16"/><path d="M4 18h16"/>
                    </svg>
                    <svg id="menu-close-icon" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 6l12 12"/><path d="M18 6 6 18"/>
                    </svg>
                </button>

            </div>
        </div>

        {{-- Mobile navigation --}}
        <div id="mobile-menu" class="hidden border-t border-slate-100 py-4 md:hidden">
            <nav class="space-y-1">

                @foreach ($links as $link)
                    <a href="{{ $link['href'] }}"
                       @class([
                           'block rounded-lg px-3 py-2.5 text-sm font-medium',
                           'bg-blue-50 text-blue-700' => $link['active'],
                           'text-slate-600 hover:bg-slate-100' => ! $link['active'],
                       ])>
                        {{ $link['label'] }}
                    </a>
                @endforeach

                <div class="my-3 border-t border-slate-100"></div>

                @auth
                    <div class="flex items-center gap-3 px-3 py-2">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                            {{ $initial }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <a href="{{ route('profile') }}"
                       class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100">
                        My Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="mt-1">
                        @csrf
                        <button type="submit"
                                class="w-full rounded-lg px-3 py-2.5 text-left text-sm font-medium text-red-600 hover:bg-red-50">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="mt-1 block rounded-lg bg-blue-600 px-3 py-2.5 text-center text-sm font-semibold
                              text-white hover:bg-blue-700">
                        Create Account
                    </a>
                @endauth

            </nav>
        </div>

    </div>
</header>