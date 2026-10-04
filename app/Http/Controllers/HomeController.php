<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
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

        $categories = Category::withCount('books')
            ->orderBy('name')
            ->get();

        // guest | none | pending | rejected | inactive | member
        $user = $request->user();
        $member = $user?->member;
        $myLoans = null;

        if (! $user) {
            $membershipState = 'guest';
        } elseif ($member) {
            $membershipState = ($member->status === 'active' && ! $member->membership_expiry_date->isPast())
                ? 'member'
                : 'inactive';

            $active = $member->borrowings()
                ->with('book')
                ->whereNull('returned_at')
                ->orderBy('due_date')
                ->get();

            $myLoans = [
                'count' => $active->count(),
                'overdue' => $active->filter(fn ($b) => $b->due_date->lt(today()))->count(),
                'next' => $active->first(),
            ];
        } else {
            $membershipState = match ($user->membershipApplication?->status) {
                'pending' => 'pending',
                'rejected' => 'rejected',
                default => 'none',
            };
        }

        return view('home', compact('stats', 'recentBooks', 'categories', 'membershipState', 'myLoans'));
    }
}