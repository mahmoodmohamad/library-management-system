<footer class="border-t border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

            {{-- Brand --}}
            <div class="flex items-center gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-white">
                    <svg
                        class="h-4.5 w-4.5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        aria-hidden="true"
                    >
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-900">
                        Library Management
                    </p>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Discover. Borrow. Read.
                    </p>
                </div>

            </div>


            {{-- Copyright --}}
            <div class="flex flex-col gap-1 sm:items-end">

                <p class="text-xs text-slate-500">
                    &copy; {{ date('Y') }} Library Management System
                </p>

                <p class="text-xs text-slate-400">
                    All rights reserved.
                </p>

            </div>

        </div>

    </div>
</footer>