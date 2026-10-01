@extends('layouts.app')

@section('title', $book->title)

@php
    $viewer = auth()->user();
    $viewerMember = $viewer?->member;
    $application = $viewer?->membershipApplication;
    $activeBorrowing = $activeBorrowing ?? null;
    $activeReservation = $activeReservation ?? null;
    $available = $book->available_quantity;

    // One state drives the whole action card.
    $state = match (true) {
        ! $viewer                                  => 'guest',
        ! $viewerMember && $application?->status === 'pending'  => 'pending',
        ! $viewerMember && $application?->status === 'rejected' => 'rejected',
        ! $viewerMember                            => 'no_member',
        (bool) $activeBorrowing                    => 'borrowed',
        $available > 0                             => 'can_borrow',
        (bool) $activeReservation                  => 'reserved',
        default                                    => 'can_reserve',
    };

    $daysLeft = $activeBorrowing
        ? (int) today()->diffInDays($activeBorrowing->due_date, false)
        : null;

    $btn = 'inline-flex w-full items-center justify-center rounded-lg px-5 py-3 text-sm font-semibold shadow-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2';
    $btnPrimary = $btn.' bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500';
    $btnOutline = $btn.' border border-slate-300 bg-white text-slate-700 shadow-none hover:bg-slate-50 focus:ring-slate-300';
@endphp

@section('content')

<div class="space-y-6">

    {{-- Back --}}
    <a href="{{ url('/books') }}"
       class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition hover:text-blue-600">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m15 18-6-6 6-6"/>
        </svg>
        Back to books
    </a>

    <div class="grid gap-x-10 gap-y-8 lg:grid-cols-3">

        {{-- ================= Header ================= --}}
        <header class="flex gap-6 lg:col-span-2">

            {{-- Cover placeholder --}}
            <div class="hidden h-44 w-32 shrink-0 items-center justify-center rounded-xl
                        border border-slate-200 bg-slate-100 sm:flex">
                <svg class="h-12 w-12 text-slate-300" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.5">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                </svg>
            </div>

            <div class="min-w-0">

                @if($book->category)
                    <p class="text-sm font-semibold text-blue-600">{{ $book->category->name }}</p>
                @endif

                <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    {{ $book->title }}
                </h1>

                @if($book->authors->isNotEmpty())
                    <p class="mt-2 text-base text-slate-600">
                        by {{ $book->authors->pluck('name')->join(', ') }}
                    </p>
                @endif

                {{-- Availability --}}
                <div class="mt-5 flex items-center gap-2 text-sm">
                    @if($available > 0)
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        <span class="font-semibold text-emerald-700">Available</span>
                        <span class="text-slate-500">
                            · {{ $available }} of {{ $book->total_copies }}
                            {{ $book->total_copies === 1 ? 'copy' : 'copies' }} on the shelf
                        </span>
                    @else
                        <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>
                        <span class="font-semibold text-red-700">Unavailable</span>
                        <span class="text-slate-500">· all copies are on loan</span>
                    @endif
                </div>

            </div>
        </header>


        {{-- ================= Action card ================= --}}
        <aside class="lg:col-start-3 lg:row-span-2 lg:row-start-1">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:sticky lg:top-24">

                @switch($state)

                    @case('guest')
                        <h2 class="text-lg font-bold text-slate-900">Sign in to borrow</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            You need an account and a library membership to borrow books.
                        </p>
                        <div class="mt-5 space-y-2">
                            <a href="{{ route('login') }}" class="{{ $btnPrimary }}">Sign in</a>
                            <a href="{{ route('register') }}" class="{{ $btnOutline }}">Create account</a>
                        </div>
                        @break

                    @case('no_member')
                        <h2 class="text-lg font-bold text-slate-900">Membership required</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Borrowing is for library members. Send a short application and the library will review it.
                        </p>
                        <div class="mt-5">
                            <a href="{{ route('membership.apply') }}" class="{{ $btnPrimary }}">Apply for membership</a>
                        </div>
                        @break

                    @case('rejected')
                        <h2 class="text-lg font-bold text-slate-900">Application not approved</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            You can update your details and apply again.
                        </p>
                        <div class="mt-5">
                            <a href="{{ route('membership.apply') }}" class="{{ $btnPrimary }}">Apply again</a>
                        </div>
                        @break

                    @case('pending')
                        <h2 class="text-lg font-bold text-slate-900">Application under review</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            You will be able to borrow as soon as the library approves your membership.
                        </p>
                        <div class="mt-5">
                            <a href="{{ route('profile') }}" class="{{ $btnOutline }}">View my profile</a>
                        </div>
                        @break

                    @case('borrowed')
                        <h2 class="text-lg font-bold text-slate-900">You have this book</h2>
                        <p class="mt-1 text-sm {{ $daysLeft < 0 ? 'font-medium text-red-600' : 'text-slate-500' }}">
                            @if($daysLeft < 0)
                                Overdue by {{ abs($daysLeft) }} {{ abs($daysLeft) === 1 ? 'day' : 'days' }}
                                (due {{ $activeBorrowing->due_date->format('M j, Y') }}).
                            @elseif($daysLeft === 0)
                                Due today.
                            @else
                                Due {{ $activeBorrowing->due_date->format('M j, Y') }}
                                · {{ $daysLeft }} {{ $daysLeft === 1 ? 'day' : 'days' }} left.
                            @endif
                        </p>
                        <form method="POST" action="{{ route('books.return', $book) }}"
                              onsubmit="return confirm('Return this book?')" class="mt-5">
                            @csrf
                            <button type="submit"
                                    class="{{ $btn }} bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500">
                                Return book
                            </button>
                        </form>
                        @break

                    @case('can_borrow')
                        <h2 class="text-lg font-bold text-slate-900">Ready to borrow</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Loan period: {{ config('library.loan_days') }} days.
                            Late returns are charged a daily fine.
                        </p>
                        @if($activeReservation)
                            <p class="mt-3 rounded-lg bg-blue-50 px-3 py-2 text-sm text-blue-800">
                                You reserved this book and it is now available.
                            </p>
                        @endif
                        <form method="POST" action="{{ route('books.borrow', $book) }}" class="mt-5">
                            @csrf
                            <button type="submit" class="{{ $btnPrimary }}">Borrow book</button>
                        </form>
                        @break

                    @case('reserved')
                        <h2 class="text-lg font-bold text-slate-900">You are in the queue</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            All copies are on loan. We are keeping your place for this book.
                        </p>
                        <form method="POST" action="{{ route('books.reserve.cancel', $book) }}"
                              onsubmit="return confirm('Cancel your reservation?')" class="mt-5">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="{{ $btnOutline }}">Cancel reservation</button>
                        </form>
                        @break

                    @default
                        <h2 class="text-lg font-bold text-slate-900">Currently unavailable</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            All copies are on loan. Reserve it to join the queue.
                        </p>
                        <form method="POST" action="{{ route('books.reserve', $book) }}" class="mt-5">
                            @csrf
                            <button type="submit"
                                    class="{{ $btn }} bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-400">
                                Reserve book
                            </button>
                        </form>

                @endswitch

            </div>
        </aside>


        {{-- ================= Details ================= --}}
        <div class="space-y-10 lg:col-span-2">

            <section>
                <h2 class="text-lg font-bold text-slate-900">About this book</h2>

                @if($book->description)
                    <p class="mt-3 max-w-prose whitespace-pre-line text-sm leading-7 text-slate-600">
                        {{ $book->description }}
                    </p>
                @else
                    <p class="mt-3 text-sm text-slate-400">No description available.</p>
                @endif
            </section>

            <section>
                <h2 class="text-lg font-bold text-slate-900">Details</h2>

                <dl class="mt-3 grid gap-x-10 sm:grid-cols-2">
                    @foreach ([
                        'ISBN'             => $book->isbn,
                        'Publisher'        => $book->publisher?->name,
                        'Publication year' => $book->publication_year,
                        'Pages'            => $book->pages,
                        'Shelf location'   => $book->shelf_location,
                        'Total copies'     => $book->total_copies,
                    ] as $label => $value)
                        <div class="flex items-baseline justify-between gap-4 border-b border-slate-100 py-3">
                            <dt class="text-sm text-slate-500">{{ $label }}</dt>
                            <dd class="text-right text-sm font-medium text-slate-900">{{ $value ?: '—' }}</dd>
                        </div>
                    @endforeach
                </dl>
            </section>

        </div>

    </div>

</div>

@endsection