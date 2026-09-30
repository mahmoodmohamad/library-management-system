@extends('layouts.app')

@section('title', 'Home')

@section('content')

<div class="space-y-12">

    {{-- =========================================================
         HERO
    ========================================================== --}}

    <section class="relative overflow-hidden rounded-3xl bg-slate-900">

        <div class="absolute inset-0">
            <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full
                        bg-blue-600/20 blur-3xl"></div>

            <div class="absolute -bottom-32 -left-20 h-80 w-80 rounded-full
                        bg-indigo-500/10 blur-3xl"></div>
        </div>

        <div class="relative px-6 py-14 sm:px-10 lg:px-16 lg:py-20">

            <div class="max-w-3xl">

                <span class="inline-flex items-center rounded-full
                             border border-blue-400/20 bg-blue-500/10
                             px-3 py-1 text-xs font-semibold
                             text-blue-300">

                    Your digital library

                </span>

                <h1 class="mt-5 text-4xl font-bold tracking-tight text-white
                           sm:text-5xl lg:text-6xl">

                    Discover your next
                    <span class="text-blue-400">
                        great read.
                    </span>

                </h1>

                <p class="mt-5 max-w-2xl text-base leading-7 text-slate-300
                          sm:text-lg">

                    Explore our collection, find the books you are looking for,
                    and keep track of everything you borrow from the library.

                </p>


                {{-- Search --}}
                <form action="{{ url('/books') }}"
                      method="GET"
                      class="mt-8 max-w-2xl">

                    <div class="flex flex-col gap-2 rounded-2xl bg-white p-2
                                shadow-xl sm:flex-row">

                        <div class="flex flex-1 items-center px-3">

                            <svg class="mr-3 h-5 w-5 shrink-0 text-slate-400"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">

                                <circle cx="11" cy="11" r="7"/>
                                <path d="m20 20-4-4"/>

                            </svg>

                            <input
                                type="text"
                                name="search"
                                placeholder="Search by title, ISBN or author..."
                                class="w-full border-0 bg-transparent py-3 text-sm
                                       text-slate-900 outline-none
                                       placeholder:text-slate-400
                                       focus:ring-0"
                            >

                        </div>

                        <button type="submit"
                                class="rounded-xl bg-blue-600 px-6 py-3
                                       text-sm font-semibold text-white
                                       transition hover:bg-blue-700">

                            Search Books

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>


    {{-- =========================================================
         STATISTICS
    ========================================================== --}}

    <section class="grid gap-4 sm:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <p class="text-sm font-medium text-slate-500">
                Books in Collection
            </p>

            <p class="mt-2 text-3xl font-bold text-slate-900">
                {{ number_format($stats['books']) }}
            </p>

            <p class="mt-1 text-xs text-slate-400">
                Available in our library
            </p>

        </div>


        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <p class="text-sm font-medium text-slate-500">
                Books Available
            </p>

            <p class="mt-2 text-3xl font-bold text-slate-900">
                {{ number_format($stats['available_books']) }}
            </p>

            <p class="mt-1 text-xs text-slate-400">
                Ready to be borrowed
            </p>

        </div>


        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <p class="text-sm font-medium text-slate-500">
                Active Members
            </p>

            <p class="mt-2 text-3xl font-bold text-slate-900">
                {{ number_format($stats['members']) }}
            </p>

            <p class="mt-1 text-xs text-slate-400">
                Part of our community
            </p>

        </div>

    </section>


    {{-- =========================================================
         RECENT BOOKS
    ========================================================== --}}

    <section>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-end
                    sm:justify-between">

            <div>

                <p class="text-sm font-semibold text-blue-600">
                    Explore
                </p>

                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Recently Added Books
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Discover some of the latest additions to our collection.
                </p>

            </div>

            <a href="{{ url('/books') }}"
               class="text-sm font-semibold text-blue-600 hover:text-blue-700">

                Browse all books
                <span aria-hidden="true">→</span>

            </a>

        </div>


        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

            @forelse ($recentBooks as $book)

                <article class="group overflow-hidden rounded-2xl border
                                border-slate-200 bg-white shadow-sm
                                transition duration-200
                                hover:-translate-y-1 hover:shadow-md">

                    {{-- Book Cover --}}
                    <div class="flex h-48 items-center justify-center
                                bg-gradient-to-br from-slate-100 to-slate-200">

                        <svg class="h-16 w-16 text-slate-300"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.5">

                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

                        </svg>

                    </div>


                    <div class="p-5">

                        @if ($book->category)

                            <span class="text-xs font-semibold text-blue-600">
                                {{ $book->category->name }}
                            </span>

                        @endif

                        <h3 class="mt-2 line-clamp-2 text-lg font-semibold
                                   text-slate-900 group-hover:text-blue-600">

                            {{ $book->title }}

                        </h3>


                        @if ($book->authors->isNotEmpty())

                            <p class="mt-2 text-sm text-slate-500">

                                {{ $book->authors->pluck('name')->join(', ') }}

                            </p>

                        @endif


                        <div class="mt-5 flex items-center justify-between
                                    border-t border-slate-100 pt-4">

                            @if ($book->available_quantity > 0)

                                <span class="inline-flex items-center gap-1.5
                                             text-xs font-semibold text-emerald-600">

                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                                    Available

                                </span>

                            @else

                                <span class="inline-flex items-center gap-1.5
                                             text-xs font-semibold text-slate-400">

                                    <span class="h-2 w-2 rounded-full bg-slate-300"></span>

                                    Currently unavailable

                                </span>

                            @endif


                            <a href="{{ route('books.show', $book) }}"
                               class="text-sm font-semibold text-blue-600
                                      hover:text-blue-700">

                                View book → 

                            </a>

                        </div>

                    </div>

                </article>

            @empty

                <div class="col-span-full rounded-2xl border border-dashed
                            border-slate-300 bg-white px-6 py-12 text-center">

                    <p class="font-semibold text-slate-700">
                        No books available yet
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        The library collection is currently empty.
                    </p>

                </div>

            @endforelse

        </div>

    </section>


    {{-- =========================================================
         CALL TO ACTION
    ========================================================== --}}

    <section class="rounded-2xl border border-blue-100 bg-blue-50 p-6
                    sm:p-8">

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center
                    sm:justify-between">

            <div>

                <h2 class="text-xl font-bold text-slate-900">
                    Looking for something specific?
                </h2>

                <p class="mt-1 max-w-xl text-sm text-slate-600">
                    Browse the complete collection and find your next book.
                </p>

            </div>

            <a href="{{ url('/books') }}"
               class="inline-flex shrink-0 items-center justify-center
                      rounded-xl bg-blue-600 px-5 py-2.5 text-sm
                      font-semibold text-white shadow-sm
                      transition hover:bg-blue-700">

                Browse Collection

                <span class="ml-2">
                    →
                </span>

            </a>

        </div>

    </section>

</div>

@endsection