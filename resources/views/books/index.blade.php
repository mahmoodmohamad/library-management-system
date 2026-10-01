@extends('layouts.app')

@section('title', 'Books')

@section('content')

<div class="space-y-8">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <p class="text-sm font-medium text-blue-600">
                Library Collection
            </p>

            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">
                Browse Books
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Explore the books available in the library.
            </p>
        </div>

        <div class="text-sm text-slate-500">
            {{ $books->total() }}
            {{ $books->total() === 1 ? 'book' : 'books' }}
        </div>

    </div>


    {{-- Books --}}
    @if($books->count())

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

            @foreach($books as $book)

                <article
                    class="flex h-full flex-col overflow-hidden rounded-2xl
                           border border-slate-200 bg-white shadow-sm
                           transition hover:-translate-y-0.5 hover:shadow-md"
                >

                    {{-- Cover Placeholder --}}
                    <div class="flex h-64 items-center justify-center bg-slate-100 p-6">

                        <div class="flex h-48 w-32 items-center justify-center
                                    rounded-lg bg-white shadow-md">

                            <div class="px-4 text-center">

                                <svg class="mx-auto h-12 w-12 text-blue-200"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.5">

                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>

                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

                                </svg>

                                <p class="mt-3 text-xs font-medium text-slate-400">
                                    Library Book
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Content --}}
                    <div class="flex flex-1 flex-col p-5">

                        {{-- Category --}}
                        @if($book->category)

                            <span class="w-fit rounded-full bg-blue-50
                                         px-2.5 py-1 text-xs font-semibold
                                         text-blue-700">

                                {{ $book->category->name }}

                            </span>

                        @endif


                        {{-- Title --}}
                        <h2 class="mt-3 text-lg font-bold leading-snug text-slate-900">

                            {{ $book->title }}

                        </h2>


                        {{-- Authors --}}
                        @if($book->authors->isNotEmpty())

                            <p class="mt-2 text-sm text-slate-500">

                                {{ $book->authors->pluck('name')->join(', ') }}

                            </p>

                        @endif


                        {{-- Availability --}}
                        <div class="mt-5 flex items-center justify-between gap-3">

                            @if($book->available_quantity > 0)

                                <span class="inline-flex items-center gap-2
                                             rounded-full bg-emerald-50 px-2.5 py-1.5
                                             text-xs font-semibold text-emerald-700">

                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                                    Available

                                </span>

                                <span class="text-xs text-slate-500">
                                    {{ $book->available_quantity }}
                                    {{ $book->available_quantity === 1 ? 'copy' : 'copies' }}
                                </span>

                            @else

                                <span class="inline-flex items-center gap-2
                                             rounded-full bg-red-50 px-2.5 py-1.5
                                             text-xs font-semibold text-red-700">

                                    <span class="h-2 w-2 rounded-full bg-red-500"></span>

                                    Unavailable

                                </span>

                                <span class="text-xs text-slate-500">
                                    0 copies
                                </span>

                            @endif

                        </div>


                        {{-- Action --}}
                        <div class="mt-auto pt-5">

                            <a href="{{ route('books.show', $book) }}"
                               class="inline-flex w-full items-center justify-center
                                      rounded-lg bg-blue-600 px-4 py-2.5
                                      text-sm font-semibold text-white
                                      shadow-sm transition hover:bg-blue-700">

                                View Details

                            </a>

                        </div>

                    </div>

                </article>

            @endforeach

        </div>


        {{-- Pagination --}}
        @if($books->hasPages())

            <div class="pt-2">
                {{ $books->links() }}
            </div>

        @endif


    @else

        {{-- Empty State --}}
        <div class="rounded-2xl border border-slate-200 bg-white
                    px-6 py-16 text-center shadow-sm">

            <svg class="mx-auto h-16 w-16 text-slate-300"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="1.5">

                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>

                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

            </svg>

            <h2 class="mt-5 text-lg font-bold text-slate-900">
                No books found
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                There are currently no books available in the library collection.
            </p>

        </div>

    @endif

</div>

@endsection