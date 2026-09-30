<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\View\View;

class BookController extends Controller
{
    public function show(Book $book): View
    {
        $book->load([
            'authors',
            'category',
            'publisher',
        ]);

        return view('books.show', compact('book'));
    }
}