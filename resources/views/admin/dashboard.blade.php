@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview of your library operations')

@section('content')

<div class="space-y-8">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <p class="text-sm font-medium text-blue-600">
                Library Administration
            </p>

            <h2 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">
                Welcome back, {{ auth()->user()->name }}
            </h2>

            <p class="mt-1.5 text-sm text-slate-500">
                Here's what's happening in your library today.
            </p>
        </div>

        <a
            href="{{ route('admin.books.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg
                   bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white
                   shadow-sm transition
                   hover:bg-blue-700
                   focus:outline-none focus:ring-2
                   focus:ring-blue-500 focus:ring-offset-2"
        >
            <svg
                class="h-4 w-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                aria-hidden="true"
            >
                <path d="M12 5v14"/>
                <path d="M5 12h14"/>
            </svg>

            Add Book
        </a>

    </div>


    {{-- Overview --}}
    <section>

        <div class="mb-4">
            <h3 class="text-sm font-semibold text-slate-900">
                Library overview
            </h3>

            <p class="mt-1 text-xs text-slate-500">
                Current collection, membership and borrowing activity.
            </p>
        </div>


        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Books --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <p class="text-sm font-medium text-slate-500">
                        Total books
                    </p>

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             aria-hidden="true">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                        </svg>
                    </div>

                </div>

                <p class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 tabular-nums">
                    {{ number_format($stats['total_books']) }}
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Books in collection
                </p>

            </div>


            {{-- Active Members --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <p class="text-sm font-medium text-slate-500">
                        Active members
                    </p>

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>

                </div>

                <p class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 tabular-nums">
                    {{ number_format($stats['active_members']) }}
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Currently active
                </p>

            </div>


            {{-- Books Borrowed --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <p class="text-sm font-medium text-slate-500">
                        Books on loan
                    </p>

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             aria-hidden="true">
                            <path d="M5 12h14"/>
                            <path d="m13 6 6 6-6 6"/>
                        </svg>
                    </div>

                </div>

                <p class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 tabular-nums">
                    {{ number_format($stats['books_borrowed']) }}
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Currently borrowed
                </p>

            </div>


            {{-- Overdue --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <p class="text-sm font-medium text-slate-500">
                        Overdue
                    </p>

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg
                        {{ $stats['overdue_books'] > 0
                            ? 'bg-red-50 text-red-600'
                            : 'bg-slate-100 text-slate-500' }}">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v5l3 2"/>
                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-3xl font-semibold tracking-tight tabular-nums
                    {{ $stats['overdue_books'] > 0
                        ? 'text-red-600'
                        : 'text-slate-900' }}">
                    {{ number_format($stats['overdue_books']) }}
                </p>

                <p class="mt-1 text-xs
                    {{ $stats['overdue_books'] > 0
                        ? 'text-red-500'
                        : 'text-slate-400' }}">

                    {{ $stats['overdue_books'] > 0
                        ? 'Requires attention'
                        : 'Everything is on schedule' }}

                </p>

            </div>

        </div>

    </section>


    {{-- Main Actions --}}
    <section class="grid gap-6 lg:grid-cols-3">

        {{-- Quick Actions --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-2">

            <div class="border-b border-slate-100 px-6 py-5">

                <h3 class="font-semibold text-slate-900">
                    Quick actions
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Common library operations.
                </p>

            </div>


            <div class="grid gap-3 p-5 sm:grid-cols-3">

                <a
                    href="{{ route('admin.books.create') }}"
                    class="group rounded-xl border border-slate-200 p-4
                           transition hover:border-blue-200 hover:bg-blue-50/40"
                >
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path d="M12 5v14"/>
                            <path d="M5 12h14"/>
                        </svg>
                    </div>

                    <p class="mt-3 text-sm font-semibold text-slate-900">
                        Add book
                    </p>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Add a new title to the collection.
                    </p>
                </a>


                <a
                    href="{{ route('admin.members.create') }}"
                    class="group rounded-xl border border-slate-200 p-4
                           transition hover:border-violet-200 hover:bg-violet-50/40"
                >
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M19 8v6"/>
                            <path d="M22 11h-6"/>
                        </svg>
                    </div>

                    <p class="mt-3 text-sm font-semibold text-slate-900">
                        Add member
                    </p>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Register a new library member.
                    </p>
                </a>


                <a
                    href="{{ route('admin.borrowings.index') }}"
                    class="group rounded-xl border border-slate-200 p-4
                           transition hover:border-amber-200 hover:bg-amber-50/40"
                >
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                        </svg>
                    </div>

                    <p class="mt-3 text-sm font-semibold text-slate-900">
                        Borrowing desk
                    </p>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Issue books and process returns.
                    </p>
                </a>

            </div>

        </div>


        {{-- Attention --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">

                <h3 class="font-semibold text-slate-900">
                    Attention
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Items that may need action.
                </p>

            </div>


            <div class="p-5">

                @if ($stats['overdue_books'] > 0)

                    <div class="rounded-xl border border-red-100 bg-red-50 p-4">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600">

                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path d="M12 9v4"/>
                                    <path d="M12 17h.01"/>
                                    <path d="M10.3 3.8 2.5 17a2 2 0 0 0 1.7 3h15.6a2 2 0 0 0 1.7-3L13.7 3.8a2 2 0 0 0-3.4 0Z"/>
                                </svg>

                            </div>

                            <div>
                                <p class="text-sm font-semibold text-red-900">
                                    Overdue books
                                </p>

                                <p class="mt-1 text-sm text-red-700">
                                    {{ number_format($stats['overdue_books']) }}
                                    {{ $stats['overdue_books'] === 1 ? 'book is' : 'books are' }}
                                    past the due date.
                                </p>

                                <a
                                    href="{{ route('admin.borrowings.index', ['status' => 'overdue']) }}"
                                    class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-red-700 hover:text-red-800"
                                >
                                    Review overdue books

                                    <svg class="h-3.5 w-3.5"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path d="M5 12h14"/>
                                        <path d="m13 6 6 6-6 6"/>
                                    </svg>
                                </a>
                            </div>

                        </div>

                    </div>

                @else

                    <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50 p-4">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">

                            <svg class="h-5 w-5"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path d="m5 12 4 4L19 6"/>
                            </svg>

                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-900">
                                All clear
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                No overdue books require attention.
                            </p>
                        </div>

                    </div>

                @endif

            </div>

        </div>

    </section>

</div>

@endsection