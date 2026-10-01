<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrowing>
 */
class BorrowingFactory extends Factory
{
    protected $model = Borrowing::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $borrowedAt = $this->faker->dateTimeBetween('-1 year', 'now');
        $dueDate = (clone $borrowedAt)->modify('+14 days');

        $returnedAt = $this->faker->optional(0.7)
            ->dateTimeBetween($borrowedAt, 'now');

        if ($returnedAt) {
            $status = 'returned';
        } elseif ($dueDate < now()) {
            $status = 'overdue';
        } else {
            $status = 'borrowed';
        }

        return [
            'member_id' => Member::inRandomOrder()->first()?->id ?? Member::factory(),
            'book_id' => Book::inRandomOrder()->first()?->id ?? Book::factory(),
            'borrowed_at' => $borrowedAt->format('Y-m-d'),
            'due_date' => $dueDate->format('Y-m-d'),
            'returned_at' => $returnedAt?->format('Y-m-d'),
            'status' => $status,
            'fine_amount' => $status === 'overdue'
                ? $this->faker->randomFloat(2, 1, 200)
                : 0,
        ];
    }
}