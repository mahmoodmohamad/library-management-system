@extends('layouts.admin')

@section('title', $book->exists ? 'Edit Book' : 'Add Book')

@section('content')

<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ route('admin.books.index') }}"
           class="text-sm text-slate-500 hover:text-slate-900 transition">
            ← Back to books
        </a>

        <h1 class="mt-3 text-2xl font-semibold tracking-tight text-slate-900">
            {{ $book->exists ? 'Edit book' : 'Add book' }}
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            {{ $book->exists
                ? 'Update the information for this book.'
                : 'Add a new book to the library catalog.'
            }}
        </p>
    </div>


    {{-- Errors --}}
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4">
            <p class="text-sm font-medium text-red-800">
                Please correct the following errors:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form
        method="POST"
        action="{{ $book->exists
            ? route('admin.books.update', $book)
            : route('admin.books.store') }}"
        class="max-w-5xl"
    >

        @csrf

        @if ($book->exists)
            @method('PUT')
        @endif


        {{-- Basic information --}}
        <section class="border-b border-slate-200 pb-8">

            <div class="mb-6">
                <h2 class="text-base font-semibold text-slate-900">
                    Basic information
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    General information used to identify the book.
                </p>
            </div>


            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Title --}}
                <div class="md:col-span-2">

                    <label for="title"
                           class="mb-2 block text-sm font-medium text-slate-700">
                        Title
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="title"
                        type="text"
                        name="title"
                        value="{{ old('title', $book->title) }}"
                        placeholder="Enter book title"
                        class="block w-full rounded-lg border border-slate-300
                               bg-white px-3 py-2.5 text-sm text-slate-900
                               placeholder:text-slate-400
                               focus:border-slate-500 focus:outline-none
                               focus:ring-2 focus:ring-slate-100
                               @error('title') border-red-400 @enderror"
                    >

                    @error('title')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ISBN --}}
                <div>

                    <label for="isbn"
                           class="mb-2 block text-sm font-medium text-slate-700">
                        ISBN
                    </label>

                    <input
                        id="isbn"
                        type="text"
                        name="isbn"
                        value="{{ old('isbn', $book->isbn) }}"
                        placeholder="978..."
                        class="block w-full rounded-lg border border-slate-300
                               px-3 py-2.5 text-sm text-slate-900
                               placeholder:text-slate-400
                               focus:border-slate-500 focus:outline-none
                               focus:ring-2 focus:ring-slate-100
                               @error('isbn') border-red-400 @enderror"
                    >

                    @error('isbn')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Publication Year --}}
                <div>

                    <label for="publication_year"
                           class="mb-2 block text-sm font-medium text-slate-700">
                        Publication year
                    </label>

                    <input
                        id="publication_year"
                        type="number"
                        name="publication_year"
                        value="{{ old('publication_year', $book->publication_year) }}"
                        placeholder="2026"
                        min="1000"
                        max="{{ now()->year }}"
                        class="block w-full rounded-lg border border-slate-300
                               px-3 py-2.5 text-sm text-slate-900
                               placeholder:text-slate-400
                               focus:border-slate-500 focus:outline-none
                               focus:ring-2 focus:ring-slate-100
                               @error('publication_year') border-red-400 @enderror"
                    >

                    @error('publication_year')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Pages --}}
                <div>

                    <label for="pages"
                           class="mb-2 block text-sm font-medium text-slate-700">
                        Pages
                    </label>

                    <input
                        id="pages"
                        type="number"
                        name="pages"
                        value="{{ old('pages', $book->pages) }}"
                        placeholder="350"
                        min="1"
                        class="block w-full rounded-lg border border-slate-300
                               px-3 py-2.5 text-sm text-slate-900
                               placeholder:text-slate-400
                               focus:border-slate-500 focus:outline-none
                               focus:ring-2 focus:ring-slate-100
                               @error('pages') border-red-400 @enderror"
                    >

                    @error('pages')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Shelf --}}
                <div>

                    <label for="shelf_location"
                           class="mb-2 block text-sm font-medium text-slate-700">
                        Shelf location
                    </label>

                    <input
                        id="shelf_location"
                        type="text"
                        name="shelf_location"
                        value="{{ old('shelf_location', $book->shelf_location) }}"
                        placeholder="A-12-03"
                        class="block w-full rounded-lg border border-slate-300
                               px-3 py-2.5 text-sm text-slate-900
                               placeholder:text-slate-400
                               focus:border-slate-500 focus:outline-none
                               focus:ring-2 focus:ring-slate-100
                               @error('shelf_location') border-red-400 @enderror"
                    >

                    @error('shelf_location')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Total copies --}}
                <div>

                    <label for="total_copies"
                           class="mb-2 block text-sm font-medium text-slate-700">
                        Total copies
                    </label>

                    <input
                        id="total_copies"
                        type="number"
                        name="total_copies"
                        value="{{ old('total_copies', $book->total_copies) }}"
                        min="1"
                        placeholder="5"
                        class="block w-full rounded-lg border border-slate-300
                               px-3 py-2.5 text-sm text-slate-900
                               placeholder:text-slate-400
                               focus:border-slate-500 focus:outline-none
                               focus:ring-2 focus:ring-slate-100
                               @error('total_copies') border-red-400 @enderror"
                    >

                    @error('total_copies')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </section>


        {{-- Classification --}}
        <section class="border-b border-slate-200 py-8">

            <div class="mb-6">
                <h2 class="text-base font-semibold text-slate-900">
                    Classification
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Organize the book within the library catalog.
                </p>
            </div>


            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Category --}}
                <div>

                    <label for="category_id"
                           class="mb-2 block text-sm font-medium text-slate-700">
                        Category
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        class="block w-full rounded-lg border border-slate-300
                               bg-white px-3 py-2.5 text-sm text-slate-900
                               focus:border-slate-500 focus:outline-none
                               focus:ring-2 focus:ring-slate-100
                               @error('category_id') border-red-400 @enderror"
                    >

                        <option value="">
                            Select category
                        </option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old('category_id', $book->category_id)
                                    == $category->id
                                )
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('category_id')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Publisher --}}
                <div>

                    <label for="publisher_id"
                           class="mb-2 block text-sm font-medium text-slate-700">
                        Publisher
                    </label>

                    <select
                        id="publisher_id"
                        name="publisher_id"
                        class="block w-full rounded-lg border border-slate-300
                               bg-white px-3 py-2.5 text-sm text-slate-900
                               focus:border-slate-500 focus:outline-none
                               focus:ring-2 focus:ring-slate-100
                               @error('publisher_id') border-red-400 @enderror"
                    >

                        <option value="">
                            Select publisher
                        </option>

                        @foreach ($publishers as $publisher)
                            <option
                                value="{{ $publisher->id }}"
                                @selected(
                                    old('publisher_id', $book->publisher_id)
                                    == $publisher->id
                                )
                            >
                                {{ $publisher->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('publisher_id')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Authors --}}
                <div class="md:col-span-2">

                    <label for="author_ids"
                           class="mb-2 block text-sm font-medium text-slate-700">
                        Authors
                    </label>

                    @php
                        $selectedAuthors = old(
                            'author_ids',
                            $book->authors->pluck('id')->all()
                        );
                    @endphp

                    <select
                        id="author_ids"
                        name="author_ids[]"
                        multiple
                        size="6"
                        class="block w-full rounded-lg border border-slate-300
                               bg-white px-3 py-2 text-sm text-slate-900
                               focus:border-slate-500 focus:outline-none
                               focus:ring-2 focus:ring-slate-100
                               @error('author_ids') border-red-400 @enderror"
                    >

                        @foreach ($authors as $author)
                            <option
                                value="{{ $author->id }}"
                                @selected(in_array($author->id, $selectedAuthors))
                            >
                                {{ $author->name }}
                            </option>
                        @endforeach

                    </select>

                    <p class="mt-2 text-xs text-slate-500">
                        Hold Ctrl on Windows or Cmd on Mac to select multiple authors.
                    </p>

                    @error('author_ids')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    @error('author_ids.*')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </section>


        {{-- Description --}}
        <section class="border-b border-slate-200 py-8">

            <div class="mb-6">
                <h2 class="text-base font-semibold text-slate-900">
                    Description
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Add a short description that will be displayed to library users.
                </p>
            </div>

            <textarea
                id="description"
                name="description"
                rows="6"
                placeholder="Write a description..."
                class="block w-full rounded-lg border border-slate-300
                       px-3 py-2.5 text-sm text-slate-900
                       placeholder:text-slate-400
                       focus:border-slate-500 focus:outline-none
                       focus:ring-2 focus:ring-slate-100
                       @error('description') border-red-400 @enderror"
            >{{ old('description', $book->description) }}</textarea>

            @error('description')
                <p class="mt-1.5 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </section>


        {{-- Actions --}}
        <div class="flex flex-col-reverse gap-3 py-6 sm:flex-row sm:justify-end">

            <a
                href="{{ route('admin.books.index') }}"
                class="inline-flex items-center justify-center rounded-lg
                       border border-slate-300 bg-white px-5 py-2.5
                       text-sm font-medium text-slate-700
                       transition hover:bg-slate-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-lg
                       bg-slate-900 px-5 py-2.5 text-sm font-medium text-white
                       transition hover:bg-slate-800"
            >
                {{ $book->exists ? 'Save changes' : 'Create book' }}
            </button>

        </div>

    </form>

</div>

@endsection