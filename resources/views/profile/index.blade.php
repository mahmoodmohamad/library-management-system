@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="space-y-8">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div>
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
            Account
        </p>

        <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">
            My Profile
        </h1>

        <p class="mt-2 text-slate-500">
            Manage your account and keep track of your library activity.
        </p>
    </div>


    {{-- =========================================================
         PROFILE HEADER CARD
    ========================================================== --}}

    <section class="overflow-hidden rounded-2xl border border-slate-200
                    bg-white shadow-sm">

        <div class="h-32 bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600">
        </div>

        <div class="px-6 pb-6 sm:px-8">

            <div class="-mt-12 flex flex-col gap-5 sm:flex-row sm:items-end
                        sm:justify-between">

                {{-- User --}}
                <div class="flex items-end gap-4">

                    {{-- Avatar --}}
                    <div class="flex h-24 w-24 shrink-0 items-center justify-center
                                rounded-2xl border-4 border-white bg-blue-100
                                text-3xl font-bold text-blue-700 shadow-sm">

                        {{ strtoupper(substr( auth()->user()->name, 0, 1)) }}

                    </div>


                    <div class="pb-1">

                        <h2 class="text-2xl font-bold text-slate-900">
                           {{ $user->name }}
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                        {{ $user->email }}
                        </p>

                    </div>

                </div>


                {{-- Account Status --}}
                <div class="pb-1">

                    <span class="inline-flex items-center gap-2 rounded-full
                                 bg-emerald-50 px-3 py-1.5 text-sm font-semibold
                                 text-emerald-700">

                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                        Active Account

                    </span>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
         LIBRARY SUMMARY
    ========================================================== --}}

    <section>

        <div class="mb-4">

            <h2 class="text-lg font-bold text-slate-900">
                Library Activity
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                A quick overview of your borrowing activity.
            </p>

        </div>


        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Active Borrowings --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div class="flex h-11 w-11 items-center justify-center
                                rounded-xl bg-blue-50 text-blue-600">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

                        </svg>

                    </div>

                    <span class="text-xs font-medium text-slate-400">
                        Current
                    </span>

                </div>

                <p class="mt-4 text-3xl font-bold text-slate-900">
                    {{ $activeBorrowingsCount ?? 0 }}
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Books borrowed
                </p>

            </div>


            {{-- Returned --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div class="flex h-11 w-11 items-center justify-center
                                rounded-xl bg-emerald-50 text-emerald-600">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <path d="m5 12 4 4L19 6"/>

                        </svg>

                    </div>

                    <span class="text-xs font-medium text-slate-400">
                        Completed
                    </span>

                </div>

                <p class="mt-4 text-3xl font-bold text-slate-900">
                    {{ $returnedBorrowingsCount ?? 0 }}
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Books returned
                </p>

            </div>


            {{-- Overdue --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div class="flex h-11 w-11 items-center justify-center
                                rounded-xl bg-amber-50 text-amber-600">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v5l3 2"/>

                        </svg>

                    </div>

                    <span class="text-xs font-medium text-slate-400">
                        Attention
                    </span>

                </div>

                <p class="mt-4 text-3xl font-bold text-slate-900">
                    {{ $overdueBorrowingsCount ?? 0 }}
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Overdue books
                </p>

            </div>


            {{-- Outstanding Fines --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div class="flex h-11 w-11 items-center justify-center
                                rounded-xl bg-red-50 text-red-600">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v10"/>
                            <path d="M15 9.5c-.7-1-1.7-1.5-3-1.5
                                     -1.7 0-3 1-3 2.3
                                     0 1.4 1.3 2 3 2.4
                                     1.7.4 3 1 3 2.4
                                     0 1.4-1.3 2.4-3 2.4
                                     -1.3 0-2.4-.5-3-1.5"/>

                        </svg>

                    </div>

                    <span class="text-xs font-medium text-slate-400">
                        Outstanding
                    </span>

                </div>

                <p class="mt-4 text-3xl font-bold text-slate-900">
                    {{ number_format((float) ($outstandingFines ?? 0), 2) }}
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Outstanding fines
                </p>

            </div>

        </div>

    </section>


    {{-- =========================================================
         ACCOUNT INFORMATION + QUICK ACTIONS
    ========================================================== --}}

    <div class="grid gap-6 lg:grid-cols-3">

        {{-- Account Information --}}
        <section class="lg:col-span-2 rounded-2xl border border-slate-200
                        bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">

                <h2 class="text-lg font-bold text-slate-900">
                    Account Information
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Your basic library account information.
                </p>

            </div>


            <div class="divide-y divide-slate-100">

                {{-- Name --}}
                <div class="flex flex-col gap-1 px-6 py-4 sm:flex-row
                            sm:items-center sm:justify-between">

                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide
                                  text-slate-400">
                            Full Name
                        </p>

                        <p class="mt-1 font-medium text-slate-800">
                            {{ auth()->user()->name }}
                        </p>

                    </div>

                </div>


                {{-- Email --}}
                <div class="flex flex-col gap-1 px-6 py-4 sm:flex-row
                            sm:items-center sm:justify-between">

                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide
                                  text-slate-400">
                            Email Address
                        </p>

                        <p class="mt-1 font-medium text-slate-800">
                            {{ auth()->user()->email }}
                        </p>

                    </div>

                </div>


                {{-- Member Since --}}
                <div class="flex flex-col gap-1 px-6 py-4 sm:flex-row
                            sm:items-center sm:justify-between">

                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide
                                  text-slate-400">
                            Member Since
                        </p>

                        <p class="mt-1 font-medium text-slate-800">
                            {{ auth()->user()->created_at?->format('F j, Y') ?? '—' }}
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- Quick Actions --}}
        <section class="rounded-2xl border border-slate-200
                        bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">

                <h2 class="text-lg font-bold text-slate-900">
                    Quick Actions
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Common library actions.
                </p>

            </div>


            <div class="space-y-2 p-4">

                {{-- Browse Books --}}
                <a href="{{ url('/books') }}"
                   class="flex items-center gap-3 rounded-xl px-3 py-3
                          transition hover:bg-slate-50">

                    <div class="flex h-10 w-10 items-center justify-center
                                rounded-lg bg-blue-50 text-blue-600">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

                        </svg>

                    </div>

                    <div>

                        <p class="text-sm font-semibold text-slate-800">
                            Browse Books
                        </p>

                        <p class="text-xs text-slate-400">
                            Explore the collection
                        </p>

                    </div>

                </a>


                {{-- My Borrowings --}}
                <a href="#my-borrowings"
                   class="flex items-center gap-3 rounded-xl px-3 py-3
                          transition hover:bg-slate-50">

                    <div class="flex h-10 w-10 items-center justify-center
                                rounded-lg bg-emerald-50 text-emerald-600">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <path d="M8 6h13"/>
                            <path d="M8 12h13"/>
                            <path d="M8 18h13"/>
                            <path d="M3 6h.01"/>
                            <path d="M3 12h.01"/>
                            <path d="M3 18h.01"/>

                        </svg>

                    </div>

                    <div>

                        <p class="text-sm font-semibold text-slate-800">
                            My Borrowings
                        </p>

                        <p class="text-xs text-slate-400">
                            View your borrowing history
                        </p>

                    </div>

                </a>

            </div>

        </section>

    </div>

@if($member)

    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-6 py-5">

            <h2 class="text-lg font-bold text-slate-900">
                Membership Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Your library membership details.
            </p>

        </div>

        <div class="grid gap-6 px-6 py-6 sm:grid-cols-2 lg:grid-cols-3">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Member Number
                </p>
                <p class="mt-1 font-medium text-slate-800">
                    {{ $member->member_number }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Membership Type
                </p>
                <p class="mt-1 font-medium capitalize text-slate-800">
                    {{ $member->membership_type }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Status
                </p>
                <p class="mt-1 font-medium capitalize text-slate-800">
                    {{ $member->status }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Phone
                </p>
                <p class="mt-1 font-medium text-slate-800">
                    {{ $member->phone ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Date of Birth
                </p>
                <p class="mt-1 font-medium text-slate-800">
                    {{ $member->date_of_birth?->format('F j, Y') ?? '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Membership Start
                </p>
                <p class="mt-1 font-medium text-slate-800">
                    {{ $member->membership_start_date?->format('F j, Y') ?? '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Membership Expiry
                </p>
                <p class="mt-1 font-medium text-slate-800">
                    {{ $member->membership_expiry_date?->format('F j, Y') ?? '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Emergency Contact
                </p>
                <p class="mt-1 font-medium text-slate-800">
                    {{ $member->emergency_contact_name ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Emergency Phone
                </p>
                <p class="mt-1 font-medium text-slate-800">
                    {{ $member->emergency_contact_phone ?: '—' }}
                </p>
            </div>

            <div class="sm:col-span-2 lg:col-span-3">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Address
                </p>
                <p class="mt-1 font-medium text-slate-800">
                    {{ $member->address ?: '—' }}
                </p>
            </div>

            <div class="sm:col-span-2 lg:col-span-3">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Notes
                </p>
                <p class="mt-1 text-slate-700">
                    {{ $member->notes ?: '—' }}
                </p>
            </div>

        </div>

    </section>

@else

    <section class="rounded-2xl border border-amber-200 bg-amber-50 p-6">

        <h2 class="font-semibold text-amber-900">
            You are not a library member yet
        </h2>

        <p class="mt-1 text-sm text-amber-700">
            Your account exists, but you do not currently have a library membership.
        </p>

        <a href="{{ route('membership.apply') }}"
           class="mt-4 inline-flex rounded-lg bg-blue-600 px-4 py-2.5
                  text-sm font-semibold text-white hover:bg-blue-700">
            Apply for Membership
        </a>

    </section>

@endif
    {{-- =========================================================
         MY BORROWINGS
    ========================================================== --}}

    <section id="my-borrowings"
             class="overflow-hidden rounded-2xl border border-slate-200
                    bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-slate-100
                    px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-lg font-bold text-slate-900">
                    My Borrowings
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    View your current and previous borrowed books.
                </p>

            </div>


            <a href="{{ url('/books') }}"
               class="inline-flex items-center justify-center rounded-lg
                      border border-slate-200 px-3 py-2 text-sm font-semibold
                      text-slate-700 transition hover:bg-slate-50">

                Browse Books

            </a>

        </div>


        @if(isset($borrowings) && $borrowings->count())

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="min-w-full divide-y divide-slate-100">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold
                                       uppercase tracking-wider text-slate-500">
                                Book
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold
                                       uppercase tracking-wider text-slate-500">
                                Borrowed
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold
                                       uppercase tracking-wider text-slate-500">
                                Due Date
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold
                                       uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold
                                       uppercase tracking-wider text-slate-500">
                                Fine
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 bg-white">

                        @foreach ($borrowings as $borrowing)

                            @php
                                $isReturned = !is_null($borrowing->returned_at);
                                $isOverdue = !$isReturned && $borrowing->due_date->isPast();
                            @endphp

                            <tr class="transition hover:bg-slate-50">

                                {{-- Book --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0
                                                    items-center justify-center
                                                    rounded-lg bg-slate-100
                                                    text-slate-500">

                                            <svg class="h-5 w-5"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="2">

                                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

                                            </svg>

                                        </div>


                                        <div>

                                            <p class="font-semibold text-slate-800">
                                                {{ $borrowing->book->title }}
                                            </p>

                                            @if($borrowing->book->isbn)
                                                <p class="text-xs text-slate-400">
                                                    ISBN: {{ $borrowing->book->isbn }}
                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Borrowed Date --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm
                                           text-slate-600">

                                    {{ $borrowing->borrowed_at?->format('M j, Y') ?? '—' }}

                                </td>


                                {{-- Due Date --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm">

                                    @if($isReturned)

                                        <span class="text-slate-400">
                                            —
                                        </span>

                                    @elseif($isOverdue)

                                        <span class="font-semibold text-red-600">
                                            {{ $borrowing->due_date->format('M j, Y') }}
                                        </span>

                                    @else

                                        <span class="text-slate-600">
                                            {{ $borrowing->due_date->format('M j, Y') }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    @if($isReturned)

                                        <span class="inline-flex items-center gap-1.5
                                                     rounded-full bg-emerald-50
                                                     px-2.5 py-1 text-xs font-semibold
                                                     text-emerald-700">

                                            <span class="h-1.5 w-1.5 rounded-full
                                                         bg-emerald-500"></span>

                                            Returned

                                        </span>

                                    @elseif($isOverdue)

                                        <span class="inline-flex items-center gap-1.5
                                                     rounded-full bg-red-50
                                                     px-2.5 py-1 text-xs font-semibold
                                                     text-red-700">

                                            <span class="h-1.5 w-1.5 rounded-full
                                                         bg-red-500"></span>

                                            Overdue

                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5
                                                     rounded-full bg-blue-50
                                                     px-2.5 py-1 text-xs font-semibold
                                                     text-blue-700">

                                            <span class="h-1.5 w-1.5 rounded-full
                                                         bg-blue-500"></span>

                                            Borrowed

                                        </span>

                                    @endif

                                </td>


                                {{-- Fine --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right
                                           text-sm font-medium">

                                    @if((float) $borrowing->fine_amount > 0)

                                        <span class="text-red-600">
                                            {{ number_format((float) $borrowing->fine_amount, 2) }}
                                        </span>

                                    @else

                                        <span class="text-slate-400">
                                            0.00
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Mobile Cards --}}
            <div class="divide-y divide-slate-100 md:hidden">

                @foreach ($borrowings as $borrowing)

                    @php
                        $isReturned = !is_null($borrowing->returned_at);
                        $isOverdue = !$isReturned && $borrowing->due_date->isPast();
                    @endphp

                    <div class="p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div class="flex min-w-0 items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center
                                            justify-center rounded-lg bg-slate-100
                                            text-slate-500">

                                    <svg class="h-5 w-5"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">

                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

                                    </svg>

                                </div>


                                <div class="min-w-0">

                                    <p class="truncate font-semibold text-slate-800">
                                        {{ $borrowing->book->title }}
                                    </p>

                                    @if($borrowing->book->isbn)
                                        <p class="text-xs text-slate-400">
                                            ISBN: {{ $borrowing->book->isbn }}
                                        </p>
                                    @endif

                                </div>

                            </div>


                            @if($isReturned)

                                <span class="shrink-0 rounded-full bg-emerald-50
                                             px-2.5 py-1 text-xs font-semibold
                                             text-emerald-700">
                                    Returned
                                </span>

                            @elseif($isOverdue)

                                <span class="shrink-0 rounded-full bg-red-50
                                             px-2.5 py-1 text-xs font-semibold
                                             text-red-700">
                                    Overdue
                                </span>

                            @else

                                <span class="shrink-0 rounded-full bg-blue-50
                                             px-2.5 py-1 text-xs font-semibold
                                             text-blue-700">
                                    Borrowed
                                </span>

                            @endif

                        </div>


                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">

                            <div>

                                <p class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                    Borrowed
                                </p>

                                <p class="mt-1 text-slate-700">
                                    {{ $borrowing->borrowed_at?->format('M j, Y') ?? '—' }}
                                </p>

                            </div>


                            <div>

                                <p class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                    Due Date
                                </p>

                                <p class="mt-1
                                    {{ $isOverdue
                                        ? 'font-semibold text-red-600'
                                        : 'text-slate-700' }}">

                                    {{ $borrowing->due_date?->format('M j, Y') ?? '—' }}

                                </p>

                            </div>

                        </div>


                        @if((float) $borrowing->fine_amount > 0)

                            <div class="mt-4 rounded-lg bg-red-50 px-3 py-2
                                        text-sm text-red-700">

                                Fine:
                                <span class="font-semibold">
                                    {{ number_format((float) $borrowing->fine_amount, 2) }}
                                </span>

                            </div>

                        @endif

                    </div>

                @endforeach

            </div>


            {{-- Pagination --}}
            @if(method_exists($borrowings, 'links'))

                <div class="border-t border-slate-100 px-6 py-4">

                    {{ $borrowings->withQueryString()->links() }}

                </div>

            @endif

        @else

            {{-- Empty State --}}
            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center
                            rounded-2xl bg-slate-100 text-slate-400">

                    <svg class="h-8 w-8"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8">

                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

                    </svg>

                </div>


                <h3 class="mt-5 text-lg font-semibold text-slate-900">
                    No borrowing history yet
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                    You haven't borrowed any books yet.
                    Explore the collection and find something you'd like to read.
                </p>


                <a href="{{ url('/books') }}"
                   class="mt-6 inline-flex items-center rounded-lg
                          bg-blue-600 px-4 py-2.5 text-sm font-semibold
                          text-white shadow-sm transition
                          hover:bg-blue-700">

                    Browse Books

                </a>

            </div>

        @endif

    </section>

</div>

@endsection