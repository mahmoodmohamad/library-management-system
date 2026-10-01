<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\Reservation;
use DomainException;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function reserve(Member $member, Book $book): Reservation
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

            if ($book->available_quantity > 0) {
                throw new DomainException('This book is available. Borrow it instead.');
            }

            $hasBook = Borrowing::where('member_id', $member->id)
                ->where('book_id', $book->id)
                ->whereNull('returned_at')
                ->exists();

            if ($hasBook) {
                throw new DomainException('Member already has this book.');
            }

            $alreadyReserved = Reservation::active()
                ->where('member_id', $member->id)
                ->where('book_id', $book->id)
                ->exists();

            if ($alreadyReserved) {
                throw new DomainException('You already have an active reservation for this book.');
            }

            return Reservation::create([
                'member_id' => $member->id,
                'book_id' => $book->id,
                'status' => 'active',
            ]);
        });
    }
}