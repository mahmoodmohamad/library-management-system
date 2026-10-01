<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalCopies = $this->faker->numberBetween(10, 100);

        return [
            'title' => $this->faker->sentence(3),
            'isbn' => $this->faker->unique()->isbn13(),
            'publisher_id' => Publisher::factory(),
            'description' => $this->faker->paragraph(4),
            'publication_year' => $this->faker->year(),
            'pages' => $this->faker->numberBetween(100, 600),
            'available_quantity' => $this->faker->numberBetween(0, $totalCopies),
            'total_copies' => $totalCopies,
            'shelf_location' => $this->faker->bothify('Shelf-??-###'),
            'category_id' => Category::factory(),
        ];
    }
}