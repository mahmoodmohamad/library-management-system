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
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Book::class;
    public function definition(): array
    {
        return [
            //
             'title'             => $this->faker->sentence(3),
            'isbn'              => $this->faker->unique()->isbn13(),
            'publisher_id'      => Publisher::factory(), // بيربط بجدول publishers
            'description'       => $this->faker->paragraph(4),
            'publication_year'  => $this->faker->year(),
            'pages'             => $this->faker->numberBetween(100, 600),
            'available_quantity'=> $this->faker->numberBetween(1, 50),
            'total_copies'      => $this->faker->numberBetween(10, 100),
            'shelf_location'    => $this->faker->bothify('Shelf-??-###'),
            'category_id'       => Category::factory(),
        ];
    }
}
