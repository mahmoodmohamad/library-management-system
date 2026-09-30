<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $stats = [
            'books' => Book::count(),
            'available_books' => Book::where('available_quantity', '>', 0)->count(),
            'members' => Member::where('status', 'active')->count(),
        ];

        $recentBooks = Book::with(['authors', 'category'])
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('stats', 'recentBooks'));
    }
}