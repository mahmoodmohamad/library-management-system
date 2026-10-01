<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function userWithRole(string $role): User
    {
        return User::factory()->create([
            'role_id' => Role::firstOrCreate(['name' => $role])->id,
        ]);
    }

    public function test_admin_can_delete_book(): void
    {
        $book = Book::factory()->create();

        $this->actingAs($this->userWithRole('admin'))
            ->delete(route('admin.books.destroy', $book))
            ->assertRedirect(route('admin.books.index'));

        $this->assertModelMissing($book);
    }

    public function test_librarian_can_view_but_not_delete(): void
    {
        $book = Book::factory()->create();
        $librarian = $this->userWithRole('librarian');

        $this->actingAs($librarian)
            ->get(route('admin.books.index'))
            ->assertOk();

        $this->actingAs($librarian)
            ->delete(route('admin.books.destroy', $book))
            ->assertForbidden();

        $this->assertModelExists($book);
    }

    public function test_member_cannot_access_admin_books(): void
    {
        $this->actingAs($this->userWithRole('member'))
            ->get(route('admin.books.index'))
            ->assertForbidden();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.books.index'))
            ->assertRedirect(route('login'));
    }
}