{{-- Mobile overlay --}}
<div id="sidebar-overlay"
     class="fixed inset-0 z-40 hidden bg-slate-900/50 lg:hidden"
     onclick="toggleSidebar()"></div>

<aside id="admin-sidebar"
       class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col
              border-r border-slate-200 bg-white transition-transform duration-200
              lg:translate-x-0">

    {{-- Logo --}}
    <div class="flex h-20 items-center border-b border-slate-200 px-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <p class="text-base font-bold text-slate-900">Library Admin</p>
                <p class="text-xs text-slate-500">Management System</p>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-4 py-6">

        <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Overview</p>

        <x-admin.nav-link :href="route('admin.dashboard')" :active="request()->is('admin')">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M3 13h8V3H3v10Zm10 8h8V11h-8v10ZM3 21h8v-6H3v6Zm10-18v6h8V3h-8Z"/>
            </x-slot:icon>
            Dashboard
        </x-admin.nav-link>

        <p class="mb-3 mt-8 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Library</p>

        <x-admin.nav-link :href="route('admin.books.index')" :active="request()->is('admin/books*')">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
            </x-slot:icon>
            Books
        </x-admin.nav-link>
        <x-admin.nav-link :href="route('admin.members.index')" :active="request()->is('admin/members*') && ! request()->is('admin/members/pending')">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
            </x-slot:icon>
            Members
        </x-admin.nav-link>
        <x-admin.nav-link :href="route('admin.members.pending')" :active="request()->is('admin/members/pending')">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"/>
            </x-slot:icon>
            Membership requests
        </x-admin.nav-link>
        <x-admin.nav-link :href="route('admin.borrowings.index')" :active="request()->is('admin/borrowings*')">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>
            </x-slot:icon>
            Borrowings
        </x-admin.nav-link>
        <x-admin.nav-link :href="route('admin.reports.index')" :active="request()->is('admin/reports*')">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
            </x-slot:icon>
            Reports
        </x-admin.nav-link>

    </nav>

    {{-- User --}}
    <div class="border-t border-slate-200 p-4">
        <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full
                        bg-blue-100 font-semibold text-blue-700">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                <p class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout"
                        class="rounded-lg p-2 text-slate-400 hover:bg-white hover:text-red-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4m-5-4 5-5-5-5m5 5H3"/>
                    </svg>
                </button>
            </form>

        </div>
    </div>

</aside>