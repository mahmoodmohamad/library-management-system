<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\AuthorBook;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AuthorBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = AuthorBook::class;
    public function definition(): array
    {
        return [
            //

            'book_id'   => Book::inRandomOrder()->first()?->id ?? Book::factory(),
            'author_id' => Author::inRandomOrder()->first()?->id ?? Author::factory(),
        ];
    }
}
