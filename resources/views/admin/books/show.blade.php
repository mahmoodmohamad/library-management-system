@extends('layouts.admin')
@section('title', $book->title)
@section('content')
<div class="card mb-3"><div class="card-body">
    <dl class="row mb-0">
        <dt class="col-sm-3">ISBN</dt><dd class="col-sm-9">{{ $book->isbn }}</dd>
        <dt class="col-sm-3">Authors</dt><dd class="col-sm-9">{{ $book->authors->pluck('name')->join(', ') ?: '-' }}</dd>
        <dt class="col-sm-3">Category</dt><dd class="col-sm-9">{{ $book->category?->name }}</dd>
        <dt class="col-sm-3">Publisher</dt><dd class="col-sm-9">{{ $book->publisher?->name ?: '-' }}</dd>
        <dt class="col-sm-3">Year / Pages</dt><dd class="col-sm-9">{{ $book->publication_year }} / {{ $book->pages }}</dd>
        <dt class="col-sm-3">Shelf</dt><dd class="col-sm-9">{{ $book->shelf_location ?: '-' }}</dd>
        <dt class="col-sm-3">Copies</dt><dd class="col-sm-9">{{ $book->available_quantity }} available of {{ $book->total_copies }}</dd>
        <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $book->description }}</dd>
    </dl>
</div></div>
<a href="{{ route('books.edit', $book) }}" class="btn btn-primary">Edit</a>
<a href="{{ route('books.index') }}" class="btn btn-link">Back</a>
@endsection
