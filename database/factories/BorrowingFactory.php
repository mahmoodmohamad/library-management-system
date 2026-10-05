<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Default state: an active loan that is not yet due.
 * Fines are only charged at return time (see BorrowingService), so unreturned loans have fine 0.
 * Active loans take one copy out of stock, like BorrowingService::borrow() does.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrowing>
 */
class BorrowingFactory extends Factory
{
    protected $model = Borrowing::class;

    private function loanDays(): int
    {
        return (int) config('library.loan_days', 14);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Borrowing $borrowing) {
            if ($borrowing->returned_at === null) {
                Book::whereKey($borrowing->book_id)
                    ->where('available_quantity', '>', 0)
                    ->decrement('available_quantity');
            }
        });
    }

    public function definition(): array
    {
        $borrowedAt = now()->subDays($this->faker->numberBetween(0, $this->loanDays() - 1));

        return [
            'member_id' => Member::factory(),
            'book_id' => Book::factory(),
            'borrowed_at' => $borrowedAt->toDateString(),
            'due_date' => $borrowedAt->copy()->addDays($this->loanDays())->toDateString(),
            'returned_at' => null,
            'status' => 'borrowed',
            'fine_amount' => 0,
        ];
    }

    public function overdue(): static
    {
        return $this->state(function () {
            $borrowedAt = now()->subDays($this->loanDays() + $this->faker->numberBetween(2, 20));

            return [
                'borrowed_at' => $borrowedAt->toDateString(),
                'due_date' => $borrowedAt->copy()->addDays($this->loanDays())->toDateString(),
                'returned_at' => null,
                'status' => 'overdue',
                'fine_amount' => 0,
            ];
        });
    }

    public function returned(): static
    {
        return $this->state(function () {
            $borrowedAt = now()->subDays($this->faker->numberBetween($this->loanDays() + 1, 60));
            $returnedAt = $borrowedAt->copy()->addDays($this->faker->numberBetween(1, $this->loanDays()));

            return [
                'borrowed_at' => $borrowedAt->toDateString(),
                'due_date' => $borrowedAt->copy()->addDays($this->loanDays())->toDateString(),
                'returned_at' => $returnedAt->toDateString(),
                'status' => 'returned',
                'fine_amount' => 0,
            ];
        });
    }
}