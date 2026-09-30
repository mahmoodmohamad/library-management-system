@extends('layouts.app')

@section('title', $book->title)

@section('content')

<div class="space-y-6">

    {{-- Back --}}
    <div>
        <a href="{{ url('/books') }}"
           class="inline-flex items-center gap-2 text-sm font-medium
                  text-slate-500 transition hover:text-blue-600">

            <svg class="h-4 w-4"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">

                <path d="m15 18-6-6 6-6"/>

            </svg>

            Back to Books

        </a>
    </div>


    {{-- Book Details --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200
                    bg-white shadow-sm">

        <div class="grid lg:grid-cols-3">

            {{-- Book Cover Placeholder --}}
            <div class="flex min-h-[420px] items-center justify-center
                        bg-slate-100 p-8">

                <div class="flex h-72 w-52 items-center justify-center
                            rounded-xl bg-white shadow-lg">

                    <div class="px-6 text-center">

                        <svg class="mx-auto h-16 w-16 text-blue-200"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.5">

                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>

                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

                        </svg>

                        <p class="mt-4 text-sm font-medium text-slate-400">
                            Library Book
                        </p>

                    </div>

                </div>

            </div>


            {{-- Information --}}
            <div class="p-6 sm:p-8 lg:col-span-2">

                {{-- Category --}}
                @if($book->category)

                    <span class="inline-flex rounded-full bg-blue-50
                                 px-3 py-1 text-xs font-semibold
                                 text-blue-700">

                        {{ $book->category->name }}

                    </span>

                @endif


                {{-- Title --}}
                <h1 class="mt-4 text-3xl font-bold tracking-tight
                           text-slate-900 sm:text-4xl">

                    {{ $book->title }}

                </h1>


                {{-- Authors --}}
                @if($book->authors->isNotEmpty())

                    <div class="mt-4">

                        <p class="text-sm text-slate-500">
                            Written by
                        </p>

                        <div class="mt-1 flex flex-wrap gap-x-2 gap-y-1">

                            @foreach($book->authors as $author)

                                <span class="font-semibold text-slate-800">

                                    {{ $author->name }}

                                    @if(!$loop->last)
                                        <span class="text-slate-400">,</span>
                                    @endif

                                </span>

                            @endforeach

                        </div>

                    </div>

                @endif


                {{-- Availability --}}
                <div class="mt-8 rounded-xl border border-slate-200
                            bg-slate-50 p-4">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                Availability
                            </p>

                            @if($book->available_quantity > 0)

                                <p class="mt-1 text-sm text-slate-500">

                                    {{ $book->available_quantity }}

                                    {{ $book->available_quantity === 1
                                        ? 'copy'
                                        : 'copies' }}

                                    available

                                </p>

                            @else

                                <p class="mt-1 text-sm text-red-600">
                                    Currently unavailable
                                </p>

                            @endif

                        </div>


                        @if($book->available_quantity > 0)

                            <span class="inline-flex items-center gap-2
                                         rounded-full bg-emerald-50 px-3 py-1.5
                                         text-xs font-semibold text-emerald-700">

                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                                Available

                            </span>

                        @else

                            <span class="inline-flex items-center gap-2
                                         rounded-full bg-red-50 px-3 py-1.5
                                         text-xs font-semibold text-red-700">

                                <span class="h-2 w-2 rounded-full bg-red-500"></span>

                                Unavailable

                            </span>

                        @endif

                    </div>

                </div>


                {{-- Book Information --}}
                <div class="mt-8">

                    <h2 class="text-lg font-bold text-slate-900">
                        Book Information
                    </h2>

                    <dl class="mt-4 divide-y divide-slate-100
                              rounded-xl border border-slate-200">

                        {{-- ISBN --}}
                        <div class="grid gap-1 px-4 py-3 sm:grid-cols-3">

                            <dt class="text-sm font-medium text-slate-500">
                                ISBN
                            </dt>

                            <dd class="text-sm text-slate-800 sm:col-span-2">
                                {{ $book->isbn ?: '—' }}
                            </dd>

                        </div>


                        {{-- Publisher --}}
                        <div class="grid gap-1 px-4 py-3 sm:grid-cols-3">

                            <dt class="text-sm font-medium text-slate-500">
                                Publisher
                            </dt>

                            <dd class="text-sm text-slate-800 sm:col-span-2">
                                {{ $book->publisher?->name ?? '—' }}
                            </dd>

                        </div>


                        {{-- Category --}}
                        <div class="grid gap-1 px-4 py-3 sm:grid-cols-3">

                            <dt class="text-sm font-medium text-slate-500">
                                Category
                            </dt>

                            <dd class="text-sm text-slate-800 sm:col-span-2">
                                {{ $book->category?->name ?? '—' }}
                            </dd>

                        </div>


                        {{-- Total Copies --}}
                        <div class="grid gap-1 px-4 py-3 sm:grid-cols-3">

                            <dt class="text-sm font-medium text-slate-500">
                                Total Copies
                            </dt>

                            <dd class="text-sm text-slate-800 sm:col-span-2">
                                {{ $book->total_quantity }}
                            </dd>

                        </div>

                    </dl>

                </div>

            </div>

        </div>

    </section>


    {{-- Borrow / Reserve Action --}}
    <section class="rounded-2xl border border-slate-200
                    bg-white p-6 shadow-sm">

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center
                    sm:justify-between">

            <div>

                @if($book->available_quantity > 0)

                    <h2 class="font-bold text-slate-900">
                        Ready to borrow?
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        This book is currently available.
                    </p>

                @else

                    <h2 class="font-bold text-slate-900">
                        This book is currently borrowed
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        You can reserve it and we'll keep your request in the queue.
                    </p>

                @endif

            </div>


            <div class="flex flex-col gap-2 sm:flex-row">

                @auth

                    @if($book->available_quantity > 0)

                        {{-- Borrow --}}
                        <form method="POST"
                              action="{{ route('books.borrow', $book) }}">

                            @csrf

                            <button type="submit"
                                    class="inline-flex w-full items-center
                                           justify-center gap-2 rounded-lg
                                           bg-blue-600 px-5 py-2.5 text-sm
                                           font-semibold text-white shadow-sm
                                           transition hover:bg-blue-700
                                           sm:w-auto">

                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>

                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

                                </svg>

                                Borrow Book

                            </button>

                        </form>

                    @else

                        {{-- Reserve --}}
                        <form method="POST"
                              action="{{ route('books.reserve', $book) }}">

                            @csrf

                            <button type="submit"
                                    class="inline-flex w-full items-center
                                           justify-center gap-2 rounded-lg
                                           bg-amber-500 px-5 py-2.5 text-sm
                                           font-semibold text-white shadow-sm
                                           transition hover:bg-amber-600
                                           sm:w-auto">

                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path d="M6 3h12v18l-6-3-6 3V3Z"/>

                                </svg>

                                Reserve Book

                            </button>

                        </form>

                    @endif

                @else

                    <a href="{{ route('login') }}"
                       class="inline-flex w-full items-center
                              justify-center rounded-lg bg-blue-600
                              px-5 py-2.5 text-sm font-semibold
                              text-white shadow-sm transition
                              hover:bg-blue-700 sm:w-auto">

                        Login to Borrow

                    </a>

                @endauth


                {{-- Browse More --}}
                <a href="{{ url('/books') }}"
                   class="inline-flex w-full items-center
                          justify-center rounded-lg border
                          border-slate-200 px-5 py-2.5 text-sm
                          font-semibold text-slate-700 transition
                          hover:bg-slate-50 sm:w-auto">

                    Browse More

                </a>

            </div>

        </div>

    </section>

</div>

@endsection