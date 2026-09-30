@extends('layouts.admin')

@section('title', $book->title)
@section('page-title', 'Books')
@section('page-description', 'Book details and catalog information')

@section('content')

@php
    $available = $book->available_quantity;
    $total = $book->total_copies;
    $borrowed = $total - $available;
@endphp

<div class="mx-auto max-w-4xl">

    <a href="{{ route('admin.books.index') }}"
       class="text-sm text-slate-500 transition hover:text-slate-900">
        ← Back to books
    </a>

    {{-- Header --}}
    <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

        <div class="min-w-0">
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">
                {{ $book->title }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ $book->authors->pluck('name')->join(', ') ?: 'No author assigned' }}
            </p>
        </div>

        <div class="flex shrink-0 gap-2">
            <a href="{{ route('admin.books.edit', $book) }}"
               class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white
                      transition hover:bg-slate-800">
                Edit book
            </a>

            <form method="POST"
                  action="{{ route('admin.books.destroy', $book) }}"
                  onsubmit="return confirm('Delete this book?')">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="rounded-lg border border-slate-300 bg-white px-4 py-2
                               text-sm font-medium text-red-600 transition hover:bg-red-50">
                    Delete
                </button>
            </form>
        </div>

    </div>


    {{-- Availability --}}
    <div class="mt-8 flex flex-wrap items-baseline gap-x-8 gap-y-3 border-y border-slate-200 py-5">

        <div>
            <p class="text-sm text-slate-500">Available</p>
            <p class="mt-0.5 text-2xl font-semibold tabular-nums
                      {{ $available > 0 ? 'text-slate-900' : 'text-red-600' }}">
                {{ $available }}
                <span class="text-base font-normal text-slate-400">of {{ $total }}</span>
            </p>
        </div>

        <div>
            <p class="text-sm text-slate-500">On loan</p>
            <p class="mt-0.5 text-2xl font-semibold tabular-nums text-slate-900">
                {{ $borrowed }}
            </p>
        </div>

        @if ($available === 0)
            <p class="text-sm font-medium text-red-600 sm:ml-auto">
                All copies are on loan
            </p>
        @endif

    </div>


    {{-- Details --}}
    <dl class="grid grid-cols-1 gap-x-10 sm:grid-cols-2">

        @foreach ([
            'ISBN'             => $book->isbn,
            'Category'         => $book->category?->name,
            'Publisher'        => $book->publisher?->name,
            'Publication year' => $book->publication_year,
            'Pages'            => $book->pages,
            'Shelf location'   => $book->shelf_location,
        ] as $label => $value)

            <div class="flex items-baseline justify-between gap-4 border-b border-slate-100 py-4">
                <dt class="text-sm text-slate-500">{{ $label }}</dt>
                <dd class="text-right text-sm font-medium text-slate-900">
                    {{ $value ?: '—' }}
                </dd>
            </div>

        @endforeach

    </dl>


    {{-- Description --}}
    <section class="mt-10">

        <h3 class="text-base font-semibold text-slate-900">Description</h3>

        @if ($book->description)
            <p class="mt-3 max-w-prose whitespace-pre-line text-sm leading-7 text-slate-600">
                {{ $book->description }}
            </p>
        @else
            <p class="mt-3 text-sm text-slate-400">No description added yet.</p>
        @endif

    </section>

</div>

@endsection