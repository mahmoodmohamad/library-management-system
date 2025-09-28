<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // الأول سيّد كل الجداول المرجعية
    $this->call([
        RoleSeeder::class,
        CategorySeeder::class,
        PublisherSeeder::class,
        AuthorSeeder::class,
        BookSeeder::class,
        MemberSeeder::class,
        BorrowingSeeder::class,
        AuthorBookSeeder::class,
    ]);

    // بعدين اعمل الـ Users بعد ما يكون فيه Roles
    User::factory(10)->create();

    User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
}

}
