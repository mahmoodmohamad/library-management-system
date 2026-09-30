<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_books' => Book::count(),

            'active_members' => Member::where('status', 'active')->count(),

            'books_borrowed' => Borrowing::whereNull('returned_at')->count(),

            'overdue_books' => Borrowing::whereNull('returned_at')
                ->where('due_date', '<', today())
                ->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}