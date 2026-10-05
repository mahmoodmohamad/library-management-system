<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesDomainErrors;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Reservation;
use App\Services\BorrowingService;
use App\Services\ReservationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookController extends Controller
{
    use HandlesDomainErrors;

    public function __construct(
        private BorrowingService $borrowingService,
        private ReservationService $reservationService
    ) {
    }

    public function index(Request $request): View
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $availability = $request->query('availability');

        $books = Book::with(['authors', 'category', 'publisher'])
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%")
                        ->orWhereHas('authors', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($category, fn ($query, $category) => $query->where('category_id', $category))
            ->when($availability === 'available', fn ($query) => $query->where('available_quantity', '>', 0))
            ->when($availability === 'unavailable', fn ($query) => $query->where('available_quantity', '=', 0))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('books.index', compact('books', 'categories', 'search', 'category', 'availability'));
    }

    public function show(Book $book): View
    {
        $book->load(['authors', 'category', 'publisher']);

        $activeBorrowing = null;
        $activeReservation = null;

        $queue = Reservation::active()->where('book_id', $book->id)->orderBy('id')->pluck('member_id');
        $queueCount = $queue->count();
        $canBorrow = $book->available_quantity > $queueCount;

        $member = Auth::user()?->member;

        if ($member) {
            $activeBorrowing = Borrowing::active()
                ->where('member_id', $member->id)
                ->where('book_id', $book->id)
                ->first();

            $activeReservation = Reservation::active()
                ->where('member_id', $member->id)
                ->where('book_id', $book->id)
                ->first();

            // Same rule as BorrowingService: copies are held for members queued earlier.
            $position = $queue->search($member->id);
            $ahead = $position === false ? $queueCount : $position;
            $canBorrow = $ahead < $book->available_quantity;
        }

        return view('books.show', compact(
            'book',
            'activeBorrowing',
            'activeReservation',
            'queueCount',
            'canBorrow'
        ));
    }

    public function borrow(Book $book): RedirectResponse
    {
        $this->attempt('borrowing', fn () =>
            $this->borrowingService->borrow($this->currentMember('borrowing'), $book));

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Book borrowed successfully.');
    }

    public function returnBook(Book $book): RedirectResponse
    {
        $member = $this->currentMember('borrowing');

        $borrowing = Borrowing::active()
            ->where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->first()
            ?? throw ValidationException::withMessages([
                'borrowing' => 'You do not have an active borrowing for this book.',
            ]);

        $this->attempt('borrowing', fn () => $this->borrowingService->returnBook($borrowing));

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Book returned successfully.');
    }

    public function reserve(Book $book): RedirectResponse
    {
        $this->attempt('reservation', fn () =>
            $this->reservationService->reserve($this->currentMember('reservation'), $book));

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Book reserved. We will keep your place in the queue.');
    }

    public function cancelReservation(Book $book): RedirectResponse
    {
        $this->attempt('reservation', fn () =>
            $this->reservationService->cancel($this->currentMember('reservation'), $book));

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Reservation cancelled.');
    }
}