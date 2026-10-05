<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles first: UserFactory and every user below depend on them.
       $this->call([
    RoleSeeder::class,
    AdminSeeder::class,
    CategorySeeder::class,
    PublisherSeeder::class,
    AuthorSeeder::class,
    BookSeeder::class,
    AuthorBookSeeder::class,
    MemberSeeder::class,
    BorrowingSeeder::class,
]);

        // All passwords: "password"
       
        User::factory()->librarian()->create(['name' => 'Librarian', 'email' => 'librarian@example.com']);

        // Plain users without membership (to test the "apply" flow).
        User::factory()->create(['name' => 'Test User', 'email' => 'test@example.com']);
        User::factory()->count(3)->create();
    }
}