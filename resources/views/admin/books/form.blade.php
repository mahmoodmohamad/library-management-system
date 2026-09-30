@extends('layouts.admin')
@section('title', $book->exists ? 'Edit book' : 'Add book')
@section('content')
<form method="POST" action="{{ $book->exists ? route('books.update', $book) : route('books.store') }}" class="card card-body">
    @csrf
    @if ($book->exists) @method('PUT') @endif
    <div class="row g-3">
        @foreach (['title' => 'text', 'isbn' => 'text', 'publication_year' => 'number', 'pages' => 'number', 'total_copies' => 'number', 'shelf_location' => 'text'] as $name => $type)
            <div class="col-md-6">
                <label class="form-label">{{ Str::headline($name) }}</label>
                <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $book->$name) }}" class="form-control @error($name) is-invalid @enderror">
            </div>
        @endforeach
        <div class="col-md-6">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                <option value="">-</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}" @selected(old('category_id', $book->category_id) == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Publisher</label>
            <select name="publisher_id" class="form-select">
                <option value="">-</option>
                @foreach ($publishers as $p)
                    <option value="{{ $p->id }}" @selected(old('publisher_id', $book->publisher_id) == $p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Authors (Ctrl/Cmd + click for several)</label>
            <select name="author_ids[]" multiple size="6" class="form-select">
                @foreach ($authors as $a)
                    <option value="{{ $a->id }}" @selected(in_array($a->id, old('author_ids', $book->authors->pluck('id')->all())))>{{ $a->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $book->description) }}</textarea>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('books.index') }}" class="btn btn-link">Cancel</a>
    </div>
</form>
@endsection
