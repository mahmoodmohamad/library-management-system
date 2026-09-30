<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $user->load([
            'role',
            'member.borrowings.book',
        ]);

        $member = $user->member;

        $borrowings = $member
            ? $member->borrowings()
                ->with('book')
                ->latest('borrowed_at')
                ->paginate(10)
            : collect();

        $activeBorrowingsCount = $member
            ? $member->borrowings()->whereNull('returned_at')->count()
            : 0;

        $returnedBorrowingsCount = $member
            ? $member->borrowings()->whereNotNull('returned_at')->count()
            : 0;

        $overdueBorrowingsCount = $member
            ? $member->borrowings()
                ->whereNull('returned_at')
                ->whereDate('due_date', '<', today())
                ->count()
            : 0;

        $outstandingFines = $member
            ? $member->outstanding_fines
            : 0;

        return view('profile.index', compact(
            'user',
            'member',
            'borrowings',
            'activeBorrowingsCount',
            'returnedBorrowingsCount',
            'overdueBorrowingsCount',
            'outstandingFines'
        ));
    }
}