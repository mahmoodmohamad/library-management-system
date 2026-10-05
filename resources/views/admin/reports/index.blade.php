@extends('layouts.admin')

@section('title', 'Reports')
@section('page-title', 'Reports')
@section('page-description', 'Borrowing activity and fines')

@section('content')

<div class="space-y-8">

    {{-- Header --}}
    <div>
        <h2 class="text-xl font-semibold tracking-tight text-slate-900">
            Library Reports
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Review borrowing activity and financial activity for the selected period.
        </p>
    </div>


    {{-- Date Filter --}}
    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
            <h3 class="text-sm font-semibold text-slate-900">
                Report period
            </h3>

            <p class="mt-1 text-xs text-slate-500">
                Select the period you want to analyze.
            </p>
        </div>

        <form method="GET"
              class="flex flex-col gap-4 p-5 sm:flex-row sm:items-end sm:px-6">

            <div class="w-full sm:max-w-xs">
                <label for="from"
                       class="mb-1.5 block text-sm font-medium text-slate-700">
                    From
                </label>

                <input
                    id="from"
                    type="date"
                    name="from"
                    value="{{ $from }}"
                    class="block w-full rounded-lg border border-slate-300 bg-white
                           px-3 py-2.5 text-sm text-slate-900 shadow-sm
                           outline-none transition
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <div class="w-full sm:max-w-xs">
                <label for="to"
                       class="mb-1.5 block text-sm font-medium text-slate-700">
                    To
                </label>

                <input
                    id="to"
                    type="date"
                    name="to"
                    value="{{ $to }}"
                    class="block w-full rounded-lg border border-slate-300 bg-white
                           px-3 py-2.5 text-sm text-slate-900 shadow-sm
                           outline-none transition
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <div>
                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center
                           rounded-lg bg-blue-600 px-5 py-2.5 text-sm
                           font-semibold text-white shadow-sm transition
                           hover:bg-blue-700
                           focus:outline-none focus:ring-2
                           focus:ring-blue-500 focus:ring-offset-2
                           sm:w-auto"
                >
                    Apply
                </button>
            </div>

            @error('to')
                <p class="text-xs text-red-600 sm:self-center">
                    {{ $message }}
                </p>
            @enderror

        </form>

    </section>


    {{-- Period Statistics --}}
    <section>

        <div class="mb-4">
            <h3 class="text-sm font-semibold text-slate-900">
                In selected period
            </h3>

            <p class="mt-1 text-xs text-slate-500">
                Activity recorded between {{ $from }} and {{ $to }}.
            </p>
        </div>


        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Borrowed --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Books borrowed
                        </p>

                        <p class="mt-2 text-3xl font-semibold tracking-tight
                                  text-slate-900 tabular-nums">
                            {{ number_format($stats['borrowed']) }}
                        </p>
                    </div>

                    <div class="flex h-9 w-9 items-center justify-center
                                rounded-lg bg-blue-50 text-blue-600">

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

            </div>


            {{-- Returned --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Books returned
                        </p>

                        <p class="mt-2 text-3xl font-semibold tracking-tight
                                  text-slate-900 tabular-nums">
                            {{ number_format($stats['returned']) }}
                        </p>
                    </div>

                    <div class="flex h-9 w-9 items-center justify-center
                                rounded-lg bg-emerald-50 text-emerald-600">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             aria-hidden="true">

                            <path d="M20 6 9 17l-5-5"/>
                        </svg>

                    </div>

                </div>

            </div>


            {{-- Fines charged --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Fines charged
                        </p>

                        <p class="mt-2 text-3xl font-semibold tracking-tight
                                  text-slate-900 tabular-nums">
                            {{ number_format($stats['fines_charged'], 2) }}
                        </p>
                    </div>

                    <div class="flex h-9 w-9 items-center justify-center
                                rounded-lg bg-amber-50 text-amber-600">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             aria-hidden="true">

                            <path d="M12 2v20"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H7"/>
                        </svg>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- Current Status --}}
    <section>

        <div class="mb-4">
            <h3 class="text-sm font-semibold text-slate-900">
                Current status
            </h3>

            <p class="mt-1 text-xs text-slate-500">
                Current overdue books and outstanding member fines.
            </p>
        </div>


        <div class="grid gap-4 sm:grid-cols-2">

            {{-- Overdue --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Overdue books
                        </p>

                        <p class="mt-2 text-3xl font-semibold tracking-tight
                                  tabular-nums
                                  {{ $stats['overdue_now'] > 0
                                      ? 'text-red-600'
                                      : 'text-slate-900' }}">
                            {{ number_format($stats['overdue_now']) }}
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Currently past their due date
                        </p>
                    </div>

                    <div class="flex h-9 w-9 items-center justify-center
                                rounded-lg
                                {{ $stats['overdue_now'] > 0
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

            </div>


            {{-- Outstanding fines --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Outstanding fines
                        </p>

                        <p class="mt-2 text-3xl font-semibold tracking-tight
                                  text-slate-900 tabular-nums">
                            {{ number_format($stats['fines_outstanding'], 2) }}
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Currently owed by members
                        </p>
                    </div>

                    <div class="flex h-9 w-9 items-center justify-center
                                rounded-lg bg-red-50 text-red-600">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             aria-hidden="true">

                            <path d="M12 2v20"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H7"/>
                        </svg>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection