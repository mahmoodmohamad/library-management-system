<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        // Min 3 so tests can safely override available_quantity up to 3
        // without violating books_inventory_check (available <= total).
        $totalCopies = $this->faker->numberBetween(3, 10);

        return [
            'title' => Str::title($this->faker->words($this->faker->numberBetween(2, 5), true)),
            'isbn' => $this->faker->unique()->isbn13(),
            'publisher_id' => Publisher::factory(),
            'description' => $this->faker->paragraph(4),
            'publication_year' => $this->faker->numberBetween(1980, (int) date('Y')),
            'pages' => $this->faker->numberBetween(100, 600),
            'available_quantity' => $totalCopies,
            'total_copies' => $totalCopies,
            'shelf_location' => strtoupper($this->faker->bothify('??-###')),
            'category_id' => Category::factory(),
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn () => ['available_quantity' => 0]);
    }
}