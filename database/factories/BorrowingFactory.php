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
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Borrowing::class;
    public function definition(): array
    {
        $borrowedAt = $this->faker->dateTimeBetween('-1 year', 'now');
        $dueDate    = (clone $borrowedAt)->modify('+14 days');
        $returnedAt = $this->faker->optional(0.7)->dateTimeBetween($borrowedAt, 'now'); // 70% chance returned

        return [
            'member_id'   => Member::inRandomOrder()->first()?->id ?? Member::factory(),
            'book_id'     => Book::inRandomOrder()->first()?->id ?? Book::factory(),
            'borrowed_at' => $borrowedAt->format('Y-m-d H:i:s'),
            'due_date'    => $dueDate->format('Y-m-d H:i:s'),
            'returned_at' => $returnedAt ? $returnedAt->format('Y-m-d H:i:s') : null,
            'status'      => $this->faker->randomElement(['borrowed', 'returned', 'overdue']),
            'fine_amount' => $this->faker->randomFloat(2, 0, 200),
        ];
        
    }
}
