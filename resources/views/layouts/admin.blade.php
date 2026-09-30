<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - Library Management</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

<div class="min-h-screen">

    {{-- Mobile overlay --}}
    <div id="sidebar-overlay"
         class="fixed inset-0 z-40 hidden bg-slate-900/50 lg:hidden"
         onclick="toggleSidebar()">
    </div>

    {{-- Sidebar --}}
    <aside id="admin-sidebar"
           class="fixed inset-y-0 left-0 z-50 flex w-72
                  -translate-x-full flex-col border-r border-slate-200
                  bg-white transition-transform duration-200
                  lg:translate-x-0">

        {{-- Logo --}}
        <div class="flex h-20 items-center border-b border-slate-200 px-6">

            <a href="{{ url('/admin') }}" class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center
                            rounded-xl bg-blue-600 text-white">

                    <svg class="h-6 w-6"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"/>
                    </svg>

                </div>

                <div>
                    <p class="text-base font-bold text-slate-900">
                        Library Admin
                    </p>

                    <p class="text-xs text-slate-500">
                        Management System
                    </p>
                </div>

            </a>

        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-4 py-6">

            <p class="mb-3 px-3 text-xs font-semibold
                      uppercase tracking-wider text-slate-400">
                Overview
            </p>

            {{-- Dashboard --}}
            <a href="{{ url('/admin') }}"
               class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5
               text-sm font-medium
               {{ request()->is('admin') 
                    ? 'bg-blue-50 text-blue-700'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                <svg class="h-5 w-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M3 13h8V3H3v10Zm10 8h8V11h-8v10ZM3 21h8v-6H3v6Zm10-18v6h8V3h-8Z"/>
                </svg>

                Dashboard
            </a>


            <p class="mb-3 mt-8 px-3 text-xs font-semibold
                      uppercase tracking-wider text-slate-400">
                Library
            </p>

            {{-- Books --}}
            <a href="{{ route('admin.books.index') }}"
               class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5
               text-sm font-medium
               {{ request()->is('admin/books*')
                    ? 'bg-blue-50 text-blue-700'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                <svg class="h-5 w-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                </svg>

                Books
            </a>


            {{-- Members --}}
            <a href="{{ route('admin.members.index') }}"
               class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5
               text-sm font-medium
               {{ request()->is('admin/members*')
                    ? 'bg-blue-50 text-blue-700'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                <svg class="h-5 w-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m7-8a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm9-4v6m3-3h-6"/>
                </svg>

                Members
            </a>
<a href="{{ route('admin.members.pending') }}"
   class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium
   {{ request()->is('admin/members/pending') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
    Membership requests
</a>

            {{-- Borrowings --}}
            <a href="{{ route('admin.borrowings.index') }}"
               class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5
               text-sm font-medium
               {{ request()->is('admin/borrowings*')
                    ? 'bg-blue-50 text-blue-700'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                <svg class="h-5 w-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
                </svg>

                Borrowings
            </a>

        </nav>


        {{-- User --}}
        <div class="border-t border-slate-200 p-4">

            <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">

                <div class="flex h-10 w-10 shrink-0 items-center
                            justify-center rounded-full bg-blue-100
                            font-semibold text-blue-700">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

                <div class="min-w-0 flex-1">

                    <p class="truncate text-sm font-semibold text-slate-900">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="truncate text-xs text-slate-500">
                        {{ auth()->user()->email }}
                    </p>

                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            title="Logout"
                            class="rounded-lg p-2 text-slate-400
                                   hover:bg-white hover:text-red-600">

                        <svg class="h-5 w-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4m-5-4 5-5-5-5m5 5H3"/>
                        </svg>

                    </button>
                </form>

            </div>

        </div>

    </aside>


    {{-- Main --}}
    <div class="lg:pl-72">

        {{-- Topbar --}}
        <header class="sticky top-0 z-30 flex h-20 items-center
                       justify-between border-b border-slate-200
                       bg-white/95 px-4 backdrop-blur
                       sm:px-6 lg:px-8">

            <div class="flex items-center gap-3">

                {{-- Mobile menu --}}
                <button type="button"
                        onclick="toggleSidebar()"
                        class="rounded-xl p-2 text-slate-500
                               hover:bg-slate-100 lg:hidden">

                    <svg class="h-6 w-6"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>

                </button>

                <div>

                    <h1 class="text-lg font-semibold text-slate-900">
                        @yield('page-title', 'Dashboard')
                    </h1>

                    <p class="hidden text-xs text-slate-500 sm:block">
                        @yield('page-description', 'Manage your library efficiently')
                    </p>

                </div>

            </div>


            {{-- Current user --}}
            <div class="flex items-center gap-3">

                <div class="hidden text-right sm:block">

                    <p class="text-sm font-medium text-slate-700">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-slate-400">
                        Administrator
                    </p>

                </div>

                <div class="flex h-9 w-9 items-center justify-center
                            rounded-full bg-blue-100 text-sm font-semibold
                            text-blue-700">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

            </div>

        </header>


        {{-- Content --}}
        <main class="px-4 py-6 sm:px-6 lg:px-8">

            @if(session('success'))

                <div class="mb-6 flex items-center gap-3 rounded-xl
                            border border-emerald-200 bg-emerald-50
                            px-4 py-3 text-sm text-emerald-800">

                    <span>{{ session('success') }}</span>

                </div>

            @endif


            @if(session('error'))

                <div class="mb-6 flex items-center gap-3 rounded-xl
                            border border-red-200 bg-red-50
                            px-4 py-3 text-sm text-red-800">

                    <span>{{ session('error') }}</span>

                </div>

            @endif


            @yield('content')

        </main>


        <footer class="px-4 pb-6 text-center text-xs text-slate-400
                       sm:px-6 lg:px-8">

            Library Management System · {{ date('Y') }}

        </footer>

    </div>

</div>


<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>

@stack('scripts')

</body>
</html>