<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Services\BorrowingService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookController extends Controller
{
    public function __construct(
        private BorrowingService $borrowingService
    ) {
    }

    public function show(Book $book): View
{
    $book->load(['authors', 'category', 'publisher']);

    $activeBorrowing = null;

    if (Auth::check() && $member = Auth::user()->member) {
        $activeBorrowing = Borrowing::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->whereNull('returned_at')
            ->first();
    }

    return view('books.show', compact('book', 'activeBorrowing'));
}

    public function borrow(Book $book): RedirectResponse
    {
        $member = Auth::user()->member;

        if (!$member) {
            throw ValidationException::withMessages([
                'borrowing' => 'Your account is not linked to a library member.',
            ]);
        }

        try {
            $this->borrowingService->borrow($member, $book);
        } catch (DomainException $e) {
            throw ValidationException::withMessages([
                'borrowing' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Book borrowed successfully.');
    }

    public function returnBook(Book $book): RedirectResponse
    {
        $member = Auth::user()->member;

        if (!$member) {
            throw ValidationException::withMessages([
                'borrowing' => 'Your account is not linked to a library member.',
            ]);
        }

        $borrowing = Borrowing::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->whereNull('returned_at')
            ->first();

        if (!$borrowing) {
            throw ValidationException::withMessages([
                'borrowing' => 'You do not have an active borrowing for this book.',
            ]);
        }

        try {
            $this->borrowingService->returnBook($borrowing);
        } catch (DomainException $e) {
            throw ValidationException::withMessages([
                'borrowing' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Book returned successfully.');
    }

    public function reserve(Book $book): RedirectResponse
    {
        return redirect()
            ->route('books.show', $book)
            ->with('error', 'Reservation is not implemented yet.');
    }
}