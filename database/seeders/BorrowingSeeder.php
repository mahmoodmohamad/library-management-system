<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Member;
use App\Services\BorrowingService;
use DomainException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BorrowingSeeder extends Seeder
{
    public function run(BorrowingService $service): void
    {
        $members = Member::where('status', 'active')->get();
        $books = Book::all();

        if ($members->isEmpty() || $books->isEmpty()) {
            return;
        }

        foreach (range(1, 20) as $i) {
            $daysAgo = random_int(1, 60);
            $borrowedOn = now()->subDays($daysAgo);

            try {
                Carbon::setTestNow($borrowedOn);
                $borrowing = $service->borrow($members->random(), $books->random());

                if (random_int(1, 100) <= 70) {
                    $returnAfter = random_int(1, min($daysAgo, 25));
                    Carbon::setTestNow($borrowedOn->copy()->addDays($returnAfter));
                    $service->returnBook($borrowing);
                }
            } catch (DomainException) {
                // duplicate / no stock: skip
            } finally {
                Carbon::setTestNow();
            }
        }
    }
}