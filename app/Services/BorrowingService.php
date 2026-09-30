<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use DomainException;
use Illuminate\Support\Facades\DB;

class BorrowingService
{
    public function borrow(Member $member, Book $book): Borrowing
    {
        return DB::transaction(function () use ($member, $book) {
            $member = Member::lockForUpdate()->findOrFail($member->id);
            $book = Book::lockForUpdate()->findOrFail($book->id);

            if ($member->status !== 'active') {
                throw new DomainException('Member is not active.');
            }

            if ($member->membership_expiry_date->isPast()) {
                throw new DomainException('Membership has expired.');
            }

            if ($book->available_quantity < 1) {
                throw new DomainException('No copies available.');
            }

            $alreadyBorrowed = Borrowing::where('member_id', $member->id)
                ->where('book_id', $book->id)
                ->whereNull('returned_at')
                ->exists();

            if ($alreadyBorrowed) {
                throw new DomainException('Member already has this book.');
            }

            $book->decrement('available_quantity');

            return Borrowing::create([
                'member_id' => $member->id,
                'book_id' => $book->id,
                'borrowed_at' => today(),
                'due_date' => today()->addDays(config('library.loan_days')),
                'status' => 'borrowed',
                'fine_amount' => 0,
            ]);
        });
    }

    public function returnBook(Borrowing $borrowing): Borrowing
    {
        return DB::transaction(function () use ($borrowing) {
            $borrowing = Borrowing::lockForUpdate()->findOrFail($borrowing->id);

            if ($borrowing->returned_at !== null) {
                throw new DomainException('Book already returned.');
            }

            $overdueDays = max(0, (int) $borrowing->due_date->diffInDays(today(), false));
            $fine = $overdueDays * config('library.fine_per_day');

            $borrowing->update([
                'returned_at' => today(),
                'status' => 'returned',
                'fine_amount' => $fine,
            ]);

            Book::whereKey($borrowing->book_id)->increment('available_quantity');

            if ($fine > 0) {
                Member::whereKey($borrowing->member_id)->increment('outstanding_fines', $fine);
            }

            return $borrowing;
        });
    }
}