@extends('layouts.app')

@section('title', 'Home')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:opsz,wght@6..72,500;6..72,600&display=swap" rel="stylesheet">
    <style>
        .font-display { font-family: 'Newsreader', Georgia, 'Times New Roman', serif; }
    </style>
@endpush

@section('content')

@php
    // Deterministic cover colour per title (no cover images in the schema).
    $palettes = [
        'from-sky-700 to-blue-900',
        'from-emerald-700 to-teal-900',
        'from-rose-700 to-red-900',
        'from-amber-600 to-orange-800',
        'from-violet-700 to-purple-900',
        'from-cyan-700 to-sky-900',
        'from-slate-600 to-slate-800',
    ];
    $cover = fn ($book) => $palettes[crc32($book->title) % count($palettes)];

    $topCategories = $categories->where('books_count', '>', 0)->sortByDesc('books_count')->take(6);

    $banner = match ($membershipState) {
        'guest' => [
            'title' => 'Create an account to start borrowing',
            'text' => 'Registration is free. After that, apply for a library membership.',
            'cta' => ['Create account', route('register')],
            'alt' => ['Sign in', route('login')],
            'tone' => 'blue',
        ],
        'none' => [
            'title' => 'You are one step away from borrowing',
            'text' => 'Send a membership application. The library reviews it and activates your card.',
            'cta' => ['Apply for membership', route('membership.apply')],
            'alt' => null,
            'tone' => 'blue',
        ],
        'pending' => [
            'title' => 'Your membership application is under review',
            'text' => 'You can still browse. You can edit your details until the library approves them.',
            'cta' => ['Edit application', route('membership.apply')],
            'alt' => null,
            'tone' => 'amber',
        ],
        'rejected' => [
            'title' => 'Your membership application was not approved',
            'text' => 'Check your details and apply again.',
            'cta' => ['Update and reapply', route('membership.apply')],
            'alt' => null,
            'tone' => 'red',
        ],
        'inactive' => [
            'title' => 'Your membership is not active',
            'text' => 'It is suspended or expired, so borrowing is paused. Contact the library to renew.',
            'cta' => ['View my profile', route('profile')],
            'alt' => null,
            'tone' => 'amber',
        ],
        default => null,
    };

    $tones = [
        'blue'  => 'border-blue-200 bg-blue-50 text-blue-900',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-900',
        'red'   => 'border-red-200 bg-red-50 text-red-900',
    ];

    $stepsDone = match ($membershipState) {
        'guest' => 0,
        'member', 'inactive' => 2,
        default => 1,
    };

    $steps = [
        ['Create an account', 'Sign up with your name and email.'],
        ['Get your membership', 'Apply once. The library approves it and issues your member number.'],
        ['Borrow and return', 'Borrow from any book page. Late returns add a fine to your account.'],
    ];
@endphp

<div class="space-y-14">

    {{-- Hero --}}
    <section class="grid items-center gap-10 pt-2 lg:grid-cols-5 lg:gap-6">

        <div class="lg:col-span-3">

            <h1 class="font-display text-4xl font-semibold leading-[1.1] tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
                Find your next book and borrow it in minutes.
            </h1>

            <p class="mt-5 max-w-xl text-base leading-7 text-slate-600">
                Search the full catalogue, see what is on the shelf right now, and track your loans in one place.
            </p>

            <form action="{{ route('books.index') }}" method="GET" role="search" class="mt-8 max-w-2xl">

                <div class="flex flex-col gap-2 rounded-2xl border border-slate-300 bg-white p-2 shadow-sm
                            transition focus-within:border-blue-500 focus-within:ring-4 focus-within:ring-blue-100
                            sm:flex-row sm:items-center">

                    <div class="relative flex-1">
                        <label for="home-search" class="sr-only">Search books</label>
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>
                        </svg>
                        <input id="home-search" type="search" name="search" value="{{ request('search') }}"
                               autocomplete="off" placeholder="Title, author or ISBN"
                               class="w-full rounded-xl border-0 bg-transparent py-3 pl-10 pr-10 text-sm text-slate-900
                                      placeholder:text-slate-400 focus:outline-none focus:ring-0">
                        <kbd class="pointer-events-none absolute right-3 top-1/2 hidden -translate-y-1/2 rounded border
                                    border-slate-300 px-1.5 text-xs text-slate-400 sm:block" aria-hidden="true">/</kbd>
                    </div>

                    <label for="home-category" class="sr-only">Category</label>
                    <select id="home-category" name="category"
                            class="rounded-xl border-0 bg-slate-100 py-3 pl-3 pr-8 text-sm text-slate-700
                                   focus:outline-none focus:ring-2 focus:ring-blue-200 sm:w-44">
                        <option value="">All categories</option>

@foreach ($categories as $category)
    <option value="{{ $category->id }}"
        @selected((string) request('category') === (string) $category->id)>
        {{ $category->name }}
    </option>
@endforeach
                    </select>

                    <button type="submit"
                            class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition
                                   hover:bg-blue-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-blue-200">
                        Search
                    </button>
                </div>

                <label class="mt-3 inline-flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox"
       name="availability"
       value="available"
       @checked(request('availability') === 'available')
       class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">

Only show books available now
                </label>
            </form>

            @if ($topCategories->isNotEmpty())
                <nav class="mt-6 flex flex-wrap items-center gap-2" aria-label="Popular categories">
                    <span class="mr-1 text-sm text-slate-500">Popular:</span>
                    @foreach ($topCategories as $category)
                        <a href="{{ route('books.index', ['category' => $category->id]) }}"
                           class="rounded-full border border-slate-200 bg-white px-3 py-1.5 text-sm text-slate-700 transition
                                  hover:border-blue-300 hover:text-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-300">
                            {{ $category->name }}
                            <span class="text-slate-400">{{ $category->books_count }}</span>
                        </a>
                    @endforeach
                </nav>
            @endif

            <dl class="mt-10 flex flex-wrap gap-x-10 gap-y-4 border-t border-slate-200 pt-6">
                <div>
                    <dt class="text-sm text-slate-500">Titles</dt>
                    <dd class="font-display text-3xl font-semibold text-slate-900">{{ number_format($stats['books']) }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">On the shelf now</dt>
                    <dd class="font-display text-3xl font-semibold text-slate-900">{{ number_format($stats['available_books']) }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Active members</dt>
                    <dd class="font-display text-3xl font-semibold text-slate-900">{{ number_format($stats['members']) }}</dd>
                </div>
            </dl>
        </div>

        {{-- Cover stack --}}
        @if ($recentBooks->count() >= 3)
            <div class="relative mx-auto hidden h-80 w-full max-w-sm lg:col-span-2 lg:block" aria-hidden="true">
                @foreach ($recentBooks->take(3) as $i => $book)
                    @php
                        $pos = [
                            'left-0 top-10 -rotate-6',
                            'left-1/2 top-0 -translate-x-1/2 z-10',
                            'right-0 top-12 rotate-6',
                        ][$i];
                    @endphp
                    <div class="absolute {{ $pos }} h-64 w-44 overflow-hidden rounded-lg bg-gradient-to-br {{ $cover($book) }}
                                p-4 text-white shadow-xl ring-1 ring-black/10">
                        <span class="absolute inset-y-0 left-2.5 w-px bg-white/30"></span>
                        <p class="font-display pl-2 text-xl font-semibold leading-tight line-clamp-5">{{ $book->title }}</p>
                        @if ($book->authors->isNotEmpty())
                            <p class="absolute bottom-4 left-6 right-4 truncate text-xs text-white/70">
                                {{ $book->authors->first()->name }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

    </section>


    {{-- Member loans / membership banner --}}
    @if ($membershipState === 'member' && $myLoans)

        <section class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-5 sm:flex-row sm:items-center sm:justify-between"
                 aria-label="Your loans">
            <div>
                @if ($myLoans['count'] === 0)
                    <h2 class="font-semibold text-slate-900">You have no books out</h2>
                    <p class="mt-1 text-sm text-slate-500">Pick something from the catalogue to get started.</p>
                @else
                    <h2 class="font-semibold text-slate-900">
                        You have {{ $myLoans['count'] }} {{ Str::plural('book', $myLoans['count']) }} out
                        @if ($myLoans['overdue'] > 0)
                            <span class="text-red-600">({{ $myLoans['overdue'] }} overdue)</span>
                        @endif
                    </h2>
                    @if ($myLoans['next'])
                        <p class="mt-1 text-sm {{ $myLoans['next']->due_date->lt(today()) ? 'text-red-600' : 'text-slate-500' }}">
                            {{ $myLoans['next']->due_date->lt(today()) ? 'Was due' : 'Next due' }}
                            {{ $myLoans['next']->due_date->format('M j') }}:
                            {{ $myLoans['next']->book?->title }}
                        </p>
                    @endif
                @endif
            </div>
            <a href="{{ route('profile') }}#my-borrowings"
               class="inline-flex shrink-0 items-center justify-center rounded-lg border border-slate-300 px-4 py-2.5 text-sm
                      font-semibold text-slate-700 transition hover:bg-slate-50">
                View my loans
            </a>
        </section>

    @elseif ($banner)

        <section class="flex flex-col gap-4 rounded-2xl border p-5 sm:flex-row sm:items-center sm:justify-between {{ $tones[$banner['tone']] }}"
                 aria-label="Membership">
            <div>
                <h2 class="font-semibold">{{ $banner['title'] }}</h2>
                <p class="mt-1 text-sm opacity-80">{{ $banner['text'] }}</p>
            </div>
            <div class="flex shrink-0 flex-col gap-2 sm:flex-row">
                <a href="{{ $banner['cta'][1] }}"
                   class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold
                          text-white transition hover:bg-blue-700">
                    {{ $banner['cta'][0] }}
                </a>
                @if ($banner['alt'])
                    <a href="{{ $banner['alt'][1] }}"
                       class="inline-flex items-center justify-center rounded-lg border border-blue-300 bg-white px-4 py-2.5
                              text-sm font-semibold text-blue-700 transition hover:bg-blue-50">
                        {{ $banner['alt'][0] }}
                    </a>
                @endif
            </div>
        </section>

    @endif


    {{-- Recently added --}}
    <section aria-labelledby="recent-heading">

        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 id="recent-heading" class="font-display text-3xl font-semibold tracking-tight text-slate-900">
                    Recently added
                </h2>
                <p class="mt-1 text-sm text-slate-500">The newest titles in the catalogue.</p>
            </div>
            <a href="{{ route('books.index') }}" class="shrink-0 text-sm font-semibold text-blue-600 hover:text-blue-700">
                Browse all books
            </a>
        </div>

        <div class="mt-6 grid gap-4 lg:grid-cols-2">

            @forelse ($recentBooks as $book)

                @php
                    $available = $book->available_quantity;
                    $total = max($book->total_copies, 1);
                    $percent = min(100, round($available / $total * 100));
                @endphp

                <article class="group relative flex gap-4 rounded-2xl border border-slate-200 bg-white p-4 transition
                                hover:border-slate-300 hover:shadow-sm focus-within:ring-2 focus-within:ring-blue-300">

                    <div class="relative h-36 w-24 shrink-0 overflow-hidden rounded-md bg-gradient-to-br {{ $cover($book) }}
                                p-2.5 text-white shadow-sm" aria-hidden="true">
                        <span class="absolute inset-y-0 left-1.5 w-px bg-white/30"></span>
                        <p class="font-display pl-1.5 text-[13px] font-semibold leading-tight line-clamp-5">{{ $book->title }}</p>
                    </div>

                    <div class="flex min-w-0 flex-1 flex-col">

                        @if ($book->category)
                            <p class="text-xs font-medium text-blue-700">{{ $book->category->name }}</p>
                        @endif

                        <h3 class="mt-1 line-clamp-2 text-base font-semibold leading-snug text-slate-900">
                            <a href="{{ route('books.show', $book) }}"
                               class="after:absolute after:inset-0 focus:outline-none">
                                {{ $book->title }}
                            </a>
                        </h3>

                        @if ($book->authors->isNotEmpty())
                            <p class="mt-1 truncate text-sm text-slate-500">
                                {{ $book->authors->pluck('name')->join(', ') }}
                            </p>
                        @endif

                        <div class="mt-auto pt-4">
                            <div class="h-1.5 overflow-hidden rounded-full bg-slate-100"
                                 role="img" aria-label="{{ $available }} of {{ $book->total_copies }} copies available">
                                <div class="h-full rounded-full {{ $available === 0 ? 'bg-slate-300' : ($available === 1 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                                     style="width: {{ $percent }}%"></div>
                            </div>

                            <p class="mt-2 text-xs font-medium
                                      {{ $available === 0 ? 'text-slate-500' : ($available === 1 ? 'text-amber-700' : 'text-emerald-700') }}">
                                @if ($available === 0)
                                    All copies on loan
                                @elseif ($available === 1)
                                    Last copy available
                                @else
                                    {{ $available }} of {{ $book->total_copies }} copies available
                                @endif
                            </p>
                        </div>

                    </div>

                </article>

            @empty

                <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
                    <p class="font-semibold text-slate-700">The catalogue is empty</p>
                    <p class="mt-1 text-sm text-slate-500">Books will show up here as soon as the library adds them.</p>
                </div>

            @endforelse

        </div>

    </section>


    {{-- How it works --}}
    <section aria-labelledby="how-heading" class="border-t border-slate-200 pt-10">

        <h2 id="how-heading" class="font-display text-3xl font-semibold tracking-tight text-slate-900">
            How borrowing works
        </h2>

        <ol class="mt-6 grid gap-6 sm:grid-cols-3">
            @foreach ($steps as $i => [$title, $text])
                @php $done = $i < $stepsDone; @endphp
                <li class="flex gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-sm font-semibold
                                 {{ $done ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                        @if ($done)
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path d="m5 12 4 4L19 6"/>
                            </svg>
                            <span class="sr-only">Done:</span>
                        @else
                            {{ $i + 1 }}
                        @endif
                    </span>
                    <div>
                        <h3 class="font-semibold text-slate-900">{{ $title }}</h3>
                        <p class="mt-1 text-sm leading-6 text-slate-500">{{ $text }}</p>
                    </div>
                </li>
            @endforeach
        </ol>

    </section>

</div>

@endsection

@push('scripts')
<script>
    // Press "/" anywhere to jump to search.
    document.addEventListener('keydown', (e) => {
        const tag = (e.target.tagName || '').toLowerCase();
        if (e.key !== '/' || e.metaKey || e.ctrlKey || e.altKey) return;
        if (['input', 'textarea', 'select'].includes(tag) || e.target.isContentEditable) return;
        e.preventDefault();
        document.getElementById('home-search')?.focus();
    });
</script>
@endpush