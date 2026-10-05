<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id');
        $publishers = Publisher::pluck('id');

        // Reuse the seeded categories/publishers instead of letting
        // the factory create a new one for every book.
        Book::factory()
            ->count(20)
            ->state(fn () => [
                'category_id' => $categories->random(),
                'publisher_id' => $publishers->random(),
            ])
            ->create();
    }
}