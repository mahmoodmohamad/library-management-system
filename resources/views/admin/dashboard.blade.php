@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('page-description', 'Overview of your library operations')

@section('content')

<div class="space-y-8">

    {{-- Welcome Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <p class="text-sm font-medium text-blue-600">
                Library Administration
            </p>

            <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Welcome back, {{ auth()->user()->name }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Here's an overview of your library activity.
            </p>
        </div>

        <a href="{{ route('admin.books.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl
                  bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white
                  shadow-sm transition hover:bg-blue-700
                  focus:outline-none focus:ring-2 focus:ring-blue-500
                  focus:ring-offset-2">

            <svg class="h-4 w-4"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>

            Add Book
        </a>

    </div>


    {{-- Statistics --}}
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Books --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Books
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                        {{ number_format($stats['total_books']) }}
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <svg class="h-5 w-5"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                    </svg>
                </div>

            </div>

            <p class="mt-3 text-xs text-slate-400">
                Books in your collection
            </p>

        </div>


        {{-- Active Members --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Active Members
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                        {{ number_format($stats['active_members']) }}
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <svg class="h-5 w-5"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>

            </div>

            <p class="mt-3 text-xs text-slate-400">
                Currently active members
            </p>

        </div>


        {{-- Books Borrowed --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Books Borrowed
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                        {{ number_format($stats['books_borrowed']) }}
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="h-5 w-5"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M5 12h14"/>
                        <path d="M12 5l7 7-7 7"/>
                    </svg>
                </div>

            </div>

            <p class="mt-3 text-xs text-slate-400">
                Currently on loan
            </p>

        </div>


        {{-- Overdue --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Overdue
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight
                              {{ $stats['overdue_books'] > 0 ? 'text-red-600' : 'text-slate-900' }}">
                        {{ number_format($stats['overdue_books']) }}
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl
                            {{ $stats['overdue_books'] > 0
                                ? 'bg-red-50 text-red-600'
                                : 'bg-slate-100 text-slate-500' }}">

                    <svg class="h-5 w-5"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>

                </div>

            </div>

            <p class="mt-3 text-xs
                      {{ $stats['overdue_books'] > 0
                          ? 'text-red-500'
                          : 'text-slate-400' }}">

                {{ $stats['overdue_books'] > 0
                    ? 'Requires attention'
                    : 'No overdue books' }}

            </p>

        </div>

    </div>


    {{-- Quick Actions --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-6 py-5">

            <h3 class="font-semibold text-slate-900">
                Quick Actions
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Frequently used library operations
            </p>

        </div>


        <div class="grid gap-4 p-6 sm:grid-cols-3">

            {{-- Add Book --}}
            <a href="{{ route('admin.books.create') }}"
               class="group rounded-xl border border-slate-200 p-5
                      transition duration-200
                      hover:-translate-y-0.5 hover:border-blue-200
                      hover:bg-blue-50/50 hover:shadow-sm">

                <div class="flex h-10 w-10 items-center justify-center rounded-lg
                            bg-blue-50 text-blue-600
                            transition group-hover:bg-blue-100">

                    <svg class="h-5 w-5"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>

                </div>

                <h4 class="mt-4 font-semibold text-slate-900">
                    Add Book
                </h4>

                <p class="mt-1 text-sm text-slate-500">
                    Add a new book to the library collection.
                </p>

            </a>


            {{-- Add Member --}}
            <a href="{{ route('admin.members.create') }}"
               class="group rounded-xl border border-slate-200 p-5
                      transition duration-200
                      hover:-translate-y-0.5 hover:border-violet-200
                      hover:bg-violet-50/50 hover:shadow-sm">

                <div class="flex h-10 w-10 items-center justify-center rounded-lg
                            bg-violet-50 text-violet-600
                            transition group-hover:bg-violet-100">

                    <svg class="h-5 w-5"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M19 8v6"/>
                        <path d="M22 11h-6"/>
                    </svg>

                </div>

                <h4 class="mt-4 font-semibold text-slate-900">
                    Add Member
                </h4>

                <p class="mt-1 text-sm text-slate-500">
                    Register a new member in the library.
                </p>

            </a>


            {{-- Borrowing Desk --}}
            <a href="{{ route('admin.borrowings.index') }}"
               class="group rounded-xl border border-slate-200 p-5
                      transition duration-200
                      hover:-translate-y-0.5 hover:border-amber-200
                      hover:bg-amber-50/50 hover:shadow-sm">

                <div class="flex h-10 w-10 items-center justify-center rounded-lg
                            bg-amber-50 text-amber-600
                            transition group-hover:bg-amber-100">

                    <svg class="h-5 w-5"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                    </svg>

                </div>

                <h4 class="mt-4 font-semibold text-slate-900">
                    Borrowing Desk
                </h4>

                <p class="mt-1 text-sm text-slate-500">
                    Issue books, manage active loans and process returns.
                </p>

            </a>

        </div>

    </div>


    {{-- Operational Notice --}}
    @if ($stats['overdue_books'] > 0)

        <div class="flex items-start gap-4 rounded-2xl border border-red-200
                    bg-red-50 p-5">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center
                        rounded-xl bg-red-100 text-red-600">

                <svg class="h-5 w-5"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">
                    <path d="M12 9v4"/>
                    <path d="M12 17h.01"/>
                    <path d="M10.3 3.8 2.5 17a2 2 0 0 0 1.7 3h15.6a2 2 0 0 0 1.7-3L13.7 3.8a2 2 0 0 0-3.4 0Z"/>
                </svg>

            </div>

            <div class="min-w-0">

                <h3 class="font-semibold text-red-900">
                    Overdue books require attention
                </h3>

                <p class="mt-1 text-sm text-red-700">
                    There {{ $stats['overdue_books'] === 1 ? 'is' : 'are' }}
                    {{ $stats['overdue_books'] }}
                    {{ $stats['overdue_books'] === 1 ? 'book' : 'books' }}
                    currently past the due date.
                </p>

                <a href="{{ route('admin.borrowings.index', ['status' => 'overdue']) }}"
                   class="mt-3 inline-flex items-center text-sm font-semibold
                          text-red-700 hover:text-red-800">

                    Review overdue books

                    <svg class="ml-1 h-4 w-4"
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

    @endif

</div>

@endsection