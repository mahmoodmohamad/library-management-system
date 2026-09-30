<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Services\BorrowingService;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BorrowingController extends Controller
{
    public function __construct(private BorrowingService $service)
    {
    }

    public function index(Request $request)
    {
        $borrowings = Borrowing::with(['member', 'book'])
            ->when($request->status === 'out', fn ($q) => $q->whereNull('returned_at'))
            ->when($request->status === 'overdue', fn ($q) => $q->whereNull('returned_at')->where('due_date', '<', today()))
            ->when($request->status === 'returned', fn ($q) => $q->whereNotNull('returned_at'))
            ->latest('borrowed_at')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        if ($request->expectsJson()) {
            return $borrowings;
        }

        return view('admin.borrowings.index', [
            'borrowings' => $borrowings,
            'members' => Member::where('status', 'active')->orderBy('first_name')->get(),
            'books' => Book::where('available_quantity', '>', 0)->orderBy('title')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
        ]);

        try {
            $borrowing = $this->service->borrow(
                Member::findOrFail($data['member_id']),
                Book::findOrFail($data['book_id'])
            );
        } catch (DomainException $e) {
            throw ValidationException::withMessages(['borrowing' => $e->getMessage()]);
        }

        if ($request->expectsJson()) {
            return response()->json($borrowing->load(['member', 'book']), 201);
        }

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Book borrowed. Due on '.$borrowing->due_date->toDateString().'.');
    }

    public function giveBack(Request $request, Borrowing $borrowing)
    {
        try {
            $borrowing = $this->service->returnBook($borrowing);
        } catch (DomainException $e) {
            throw ValidationException::withMessages(['borrowing' => $e->getMessage()]);
        }

        if ($request->expectsJson()) {
            return $borrowing->load(['member', 'book']);
        }

        $message = 'Book returned.';
        if ((float) $borrowing->fine_amount > 0) {
            $message .= ' Late fine: '.$borrowing->fine_amount.'.';
        }

        return redirect()->route('admin.borrowings.index')->with('success', $message);
    }
}
