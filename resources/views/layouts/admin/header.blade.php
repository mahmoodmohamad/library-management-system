<header class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-slate-200
               bg-white/95 px-4 backdrop-blur sm:px-6 lg:px-8">

    <div class="flex items-center gap-3">

        {{-- Mobile menu --}}
        <button type="button" onclick="toggleSidebar()"
                class="rounded-xl p-2 text-slate-500 hover:bg-slate-100 lg:hidden">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div>
            <h1 class="text-lg font-semibold text-slate-900">@yield('page-title', 'Dashboard')</h1>
            <p class="hidden text-xs text-slate-500 sm:block">
                @yield('page-description', 'Manage your library efficiently')
            </p>
        </div>

    </div>

    {{-- Current user --}}
    <div class="flex items-center gap-3">
        <div class="hidden text-right sm:block">
            <p class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</p>
            <p class="text-xs text-slate-400">{{ ucfirst(auth()->user()->role?->name ?? 'Staff') }}</p>
        </div>

        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100
                    text-sm font-semibold text-blue-700">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </div>

</header>