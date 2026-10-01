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
use App\Services\ReservationService;
use App\Models\Reservation;
class BookController extends Controller
{
    public function __construct(
    private BorrowingService $borrowingService,
    private ReservationService $reservationService
) {
}
    public function index(): View
{
    $books = Book::with(['authors', 'category', 'publisher'])
        ->latest()
        ->paginate(12);

    return view('books.index', compact('books'));
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
$activeBorrowing = null;
$activeReservation = null;

if (Auth::check() && $member = Auth::user()->member) {
    $activeBorrowing = Borrowing::where('member_id', $member->id)
        ->where('book_id', $book->id)
        ->whereNull('returned_at')
        ->first();

    $activeReservation = Reservation::active()
        ->where('member_id', $member->id)
        ->where('book_id', $book->id)
        ->first();
}

return view('books.show', compact('book', 'activeBorrowing', 'activeReservation'));
    
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
    $member = Auth::user()->member;

    if (!$member) {
        throw ValidationException::withMessages([
            'reservation' => 'Your account is not linked to a library member.',
        ]);
    }

    try {
        $this->reservationService->reserve($member, $book);
    } catch (DomainException $e) {
        throw ValidationException::withMessages([
            'reservation' => $e->getMessage(),
        ]);
    }

    return redirect()
        ->route('books.show', $book)
        ->with('success', 'Book reserved. We will keep your place in the queue.');
}
public function cancelReservation(Book $book): RedirectResponse
{
    $member = Auth::user()->member;

    if (!$member) {
        throw ValidationException::withMessages([
            'reservation' => 'Your account is not linked to a library member.',
        ]);
    }

    try {
        $this->reservationService->cancel($member, $book);
    } catch (DomainException $e) {
        throw ValidationException::withMessages([
            'reservation' => $e->getMessage(),
        ]);
    }

    return redirect()
        ->route('books.show', $book)
        ->with('success', 'Reservation cancelled.');
}
}