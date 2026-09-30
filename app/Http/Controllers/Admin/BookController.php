<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with(['category', 'publisher', 'authors'])
            ->when($request->q, fn ($query, $s) => $query->where(
                fn ($w) => $w->where('title', 'like', "%{$s}%")->orWhere('isbn', 'like', "%{$s}%")
            ))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return $request->expectsJson() ? $books : view('admin.books.index', compact('books'));
    }

    public function show(Request $request, Book $book)
    {
        $book->load(['category', 'publisher', 'authors']);

        return $request->expectsJson() ? $book : view('admin.books.show', compact('book'));
    }

    public function create()
    {
        return view('books.form', $this->formData(new Book()));
    }

    public function edit(Book $book)
    {
        return view('admin.books.form', $this->formData($book));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $book = DB::transaction(function () use ($data) {
            $book = Book::create(Arr::except($data, ['author_ids']) + [
                'available_quantity' => $data['total_copies'],
            ]);
            $book->authors()->sync($data['author_ids'] ?? []);

            return $book;
        });

        if ($request->expectsJson()) {
            return response()->json($book->load(['category', 'publisher', 'authors']), 201);
        }

        return redirect()->route('admin.books.show', $book)->with('success', 'Book created.');
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate($this->rules($book));

        $borrowed = $book->total_copies - $book->available_quantity;

        if ($data['total_copies'] < $borrowed) {
            throw ValidationException::withMessages([
                'total_copies' => "Cannot be less than the {$borrowed} copies currently borrowed.",
            ]);
        }

        DB::transaction(function () use ($book, $data, $borrowed) {
            $book->update(Arr::except($data, ['author_ids']) + [
                'available_quantity' => $data['total_copies'] - $borrowed,
            ]);
            $book->authors()->sync($data['author_ids'] ?? []);
        });

        if ($request->expectsJson()) {
            return $book->fresh(['category', 'publisher', 'authors']);
        }

        return redirect()->route('admin.books.show', $book)->with('success', 'Book updated.');
    }

    public function destroy(Request $request, Book $book)
    {
        if ($book->borrowings()->whereNull('returned_at')->exists()) {
            throw ValidationException::withMessages([
                'book' => 'This book has copies that are still borrowed.',
            ]);
        }

        $book->delete();

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->route('admin.books.index')->with('success', 'Book deleted.');
    }

    private function rules(?Book $book = null): array
    {
        return [
            'title' => 'required|string|max:255',
            'isbn' => ['required', 'string', 'max:255', Rule::unique('books', 'isbn')->ignore($book)],
            'publisher_id' => 'nullable|exists:publishers,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'publication_year' => 'required|integer|between:1000,'.now()->year,
            'pages' => 'required|integer|min:1',
            'total_copies' => 'required|integer|min:1',
            'shelf_location' => 'nullable|string|max:255',
            'author_ids' => 'nullable|array',
            'author_ids.*' => 'exists:authors,id',
        ];
    }

    private function formData(Book $book): array
    {
        return [
            'book' => $book,
            'categories' => Category::orderBy('name')->get(),
            'publishers' => Publisher::orderBy('name')->get(),
            'authors' => Author::orderBy('name')->get(),
        ];
    }
}
