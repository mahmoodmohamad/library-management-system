@extends('layouts.admin')

@section('title', 'Borrowings')
@section('page-title', 'Borrowings')
@section('page-description', 'Manage book loans and returns')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h2 class="text-xl font-bold text-slate-900">
            Borrowing Desk
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Issue books, track active loans and process returns.
        </p>
    </div>


    {{-- Borrow Book --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-5 py-4">

            <h3 class="font-semibold text-slate-900">
                Borrow a Book
            </h3>

            <p class="mt-1 text-xs text-slate-500">
                Select an active member and an available book.
            </p>

        </div>


        <form method="POST"
              action="{{ route('admin.borrowings.store') }}"
              class="p-5">

            @csrf

            <div class="grid gap-5 lg:grid-cols-3">

                {{-- Member --}}
                <div>

                    <label for="member_id"
                           class="mb-2 block text-sm font-medium text-slate-700">

                        Member

                    </label>

                    <select
                        id="member_id"
                        name="member_id"
                        required
                        class="w-full rounded-xl border border-slate-300
                               bg-white px-3 py-2.5 text-sm text-slate-900
                               outline-none transition
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-100">

                        <option value="">
                            Select member
                        </option>

                        @foreach ($members as $m)

                            <option value="{{ $m->id }}"
                                @selected(old('member_id') == $m->id)>

                                {{ $m->member_number }}
                                —
                                {{ $m->first_name }} {{ $m->last_name }}

                            </option>

                        @endforeach

                    </select>

                    @error('member_id')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Book --}}
                <div>

                    <label for="book_id"
                           class="mb-2 block text-sm font-medium text-slate-700">

                        Book

                    </label>

                    <select
                        id="book_id"
                        name="book_id"
                        required
                        class="w-full rounded-xl border border-slate-300
                               bg-white px-3 py-2.5 text-sm text-slate-900
                               outline-none transition
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-100">

                        <option value="">
                            Select book
                        </option>

                        @foreach ($books as $b)

                            <option value="{{ $b->id }}"
                                @selected(old('book_id') == $b->id)>

                                {{ $b->title }}
                                ({{ $b->available_quantity }} available)

                            </option>

                        @endforeach

                    </select>

                    @error('book_id')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Submit --}}
                <div class="flex items-end">

                    <button type="submit"
                            class="w-full rounded-xl bg-blue-600
                                   px-4 py-2.5 text-sm font-semibold
                                   text-white shadow-sm transition
                                   hover:bg-blue-700
                                   focus:outline-none
                                   focus:ring-2 focus:ring-blue-500
                                   focus:ring-offset-2">

                        Borrow Book

                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- Filters --}}
    <div class="flex flex-wrap items-center gap-2">

        @foreach ([
            '' => 'All',
            'out' => 'Currently Out',
            'overdue' => 'Overdue',
            'returned' => 'Returned'
        ] as $value => $label)

            <a href="{{ route(
                'admin.borrowings.index',
                $value ? ['status' => $value] : []
            ) }}"
               class="rounded-lg px-3 py-2 text-sm font-medium transition
               {{ (string) request('status') === (string) $value
                    ? 'bg-blue-600 text-white'
                    : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">

                {{ $label }}

            </a>

        @endforeach

    </div>


    {{-- Borrowings Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200
                bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Member
                        </th>

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
                            Due
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Returned
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Fine
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                @forelse ($borrowings as $b)

                    @php
                        $overdue = ! $b->returned_at
                            && $b->due_date->lt(today());
                    @endphp

                    <tr class="transition hover:bg-slate-50">

                        {{-- Member --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            <a href="{{ route('admin.members.show', $b->member_id) }}"
                               class="font-semibold text-slate-900
                                      hover:text-blue-600">

                                {{ $b->member?->first_name }}
                                {{ $b->member?->last_name }}

                            </a>

                        </td>


                        {{-- Book --}}
                        <td class="max-w-xs px-6 py-4">

                            <a href="{{ route('admin.books.show', $b->book_id) }}"
                               class="font-medium text-slate-700
                                      hover:text-blue-600">

                                {{ $b->book?->title }}

                            </a>

                        </td>


                        {{-- Borrowed --}}
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                            {{ $b->borrowed_at->toDateString() }}

                        </td>


                        {{-- Due --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            <span class="text-sm
                                {{ $overdue
                                    ? 'font-semibold text-red-600'
                                    : 'text-slate-600' }}">

                                {{ $b->due_date->toDateString() }}

                            </span>

                        </td>


                        {{-- Returned --}}
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                            {{ $b->returned_at?->toDateString() ?? '—' }}

                        </td>


                        {{-- Status --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            @if ($b->returned_at)

                                <span class="inline-flex rounded-full
                                             bg-slate-100 px-2.5 py-1
                                             text-xs font-semibold
                                             text-slate-600">

                                    Returned

                                </span>

                            @elseif ($overdue)

                                <span class="inline-flex rounded-full
                                             bg-red-50 px-2.5 py-1
                                             text-xs font-semibold
                                             text-red-700">

                                    Overdue

                                </span>

                            @else

                                <span class="inline-flex rounded-full
                                             bg-blue-50 px-2.5 py-1
                                             text-xs font-semibold
                                             text-blue-700">

                                    Borrowed

                                </span>

                            @endif

                        </td>


                        {{-- Fine --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            @if((float) $b->fine_amount > 0)

                                <span class="font-semibold text-red-600">
                                    {{ number_format((float) $b->fine_amount, 2) }}
                                </span>

                            @else

                                <span class="text-sm text-slate-500">
                                    0.00
                                </span>

                            @endif

                        </td>


                        {{-- Return --}}
                        <td class="whitespace-nowrap px-6 py-4 text-right">

                            @unless ($b->returned_at)

                                <form method="POST"
                                      action="{{ route('admin.borrowings.giveBack', $b) }}"
                                      onsubmit="return confirm('Mark this book as returned?')">

                                    @csrf

                                    <button type="submit"
                                            class="rounded-lg bg-emerald-600
                                                   px-3 py-1.5 text-xs
                                                   font-semibold text-white
                                                   hover:bg-emerald-700">

                                        Return

                                    </button>

                                </form>

                            @else

                                <span class="text-xs text-slate-400">
                                    Completed
                                </span>

                            @endunless

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8"
                            class="px-6 py-12 text-center">

                            <p class="font-semibold text-slate-700">
                                No borrowings found
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                There are no records matching this filter.
                            </p>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($borrowings->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">

                {{ $borrowings->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>

@endsection