<?php

namespace Database\Seeders;

use App\Models\AuthorBook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $authorIds = \App\Models\Author::pluck('id');

    \App\Models\Book::all()->each(fn ($book) =>
        $book->authors()->sync($authorIds->random(min(rand(1, 2), $authorIds->count())))
    );
}
}
