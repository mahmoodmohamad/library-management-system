@extends('layouts.admin')

@section('title', 'Books')
@section('page-title', 'Books')
@section('page-description', 'Manage your library collection')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-xl font-bold text-slate-900">
                Books
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Browse and manage all books in your library.
            </p>
        </div>

        <a href="{{ route('admin.books.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl
                  bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white
                  shadow-sm transition hover:bg-blue-700">

            <span class="text-lg leading-none">+</span>
            Add Book

        </a>

    </div>


    {{-- Search --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

        <form method="GET" class="flex flex-col gap-3 sm:flex-row">

            <div class="relative flex-1">

                <svg class="pointer-events-none absolute left-3 top-1/2
                            h-5 w-5 -translate-y-1/2 text-slate-400"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"/>
                </svg>

                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search by title or ISBN..."
                    class="w-full rounded-xl border border-slate-300
                           bg-white py-2.5 pl-10 pr-4 text-sm
                           text-slate-900 outline-none
                           transition placeholder:text-slate-400
                           focus:border-blue-500 focus:ring-2
                           focus:ring-blue-100">

            </div>

            <button type="submit"
                    class="rounded-xl border border-slate-300
                           bg-white px-5 py-2.5 text-sm font-semibold
                           text-slate-700 transition
                           hover:bg-slate-50">

                Search

            </button>

            @if(request('q'))

                <a href="{{ route('admin.books.index') }}"
                   class="rounded-xl px-4 py-2.5 text-center
                          text-sm font-medium text-slate-500
                          hover:bg-slate-50">

                    Clear

                </a>

            @endif

        </form>

    </div>


    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200
                bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Book
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            ISBN
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Category
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Authors
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Availability
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                @forelse ($books as $book)

                    <tr class="transition hover:bg-slate-50">

                        {{-- Book --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            <a href="{{ route('admin.books.show', $book) }}"
                               class="font-semibold text-slate-900
                                      hover:text-blue-600">

                                {{ $book->title }}

                            </a>

                        </td>


                        {{-- ISBN --}}
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">

                            {{ $book->isbn }}

                        </td>


                        {{-- Category --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            <span class="text-sm text-slate-600">
                                {{ $book->category?->name ?? '—' }}
                            </span>

                        </td>


                        {{-- Authors --}}
                        <td class="max-w-xs px-6 py-4">

                            <span class="text-sm text-slate-600">
                                {{ $book->authors->pluck('name')->join(', ') ?: '—' }}
                            </span>

                        </td>


                        {{-- Availability --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            @php
                                $available = $book->available_quantity;
                                $total = $book->total_copies;
                            @endphp

                            <div class="flex items-center gap-2">

                                <span class="font-semibold text-slate-900">
                                    {{ $available }}
                                </span>

                                <span class="text-slate-400">
                                    /
                                </span>

                                <span class="text-sm text-slate-500">
                                    {{ $total }}
                                </span>

                            </div>

                            @if($available === 0)

                                <span class="mt-1 inline-flex rounded-full
                                             bg-red-50 px-2 py-0.5 text-xs
                                             font-medium text-red-700">
                                    Out of stock
                                </span>

                            @elseif($available < $total)

                                <span class="mt-1 inline-flex rounded-full
                                             bg-amber-50 px-2 py-0.5 text-xs
                                             font-medium text-amber-700">
                                    Partially available
                                </span>

                            @else

                                <span class="mt-1 inline-flex rounded-full
                                             bg-emerald-50 px-2 py-0.5 text-xs
                                             font-medium text-emerald-700">
                                    Available
                                </span>

                            @endif

                        </td>


                        {{-- Actions --}}
                        <td class="whitespace-nowrap px-6 py-4 text-right">

                            <div class="flex justify-end gap-2">

                                <a href="{{ route('admin.books.edit', $book) }}"
                                   class="rounded-lg border border-slate-300
                                          px-3 py-1.5 text-xs font-semibold
                                          text-slate-700 hover:bg-slate-50">

                                    Edit

                                </a>

                                <form method="POST"
                                      action="{{ route('admin.books.destroy', $book) }}"
                                      onsubmit="return confirm('Delete this book?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="rounded-lg border border-red-200
                                                   px-3 py-1.5 text-xs font-semibold
                                                   text-red-600 hover:bg-red-50">

                                        Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="px-6 py-12 text-center">

                            <p class="font-semibold text-slate-700">
                                No books found
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                Try changing your search or add a new book.
                            </p>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($books->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $books->withQueryString()->links() }}
            </div>

        @endif

    </div>

</div>

@endsection