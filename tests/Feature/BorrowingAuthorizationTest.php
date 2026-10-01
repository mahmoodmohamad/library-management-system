<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowingAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function userWithRole(string $role): User
    {
        return User::factory()->create([
            'role_id' => Role::firstOrCreate(['name' => $role])->id,
        ]);
    }

    public function test_librarian_can_view_borrowings(): void
    {
        $this->actingAs($this->userWithRole('librarian'))
            ->get(route('admin.borrowings.index'))
            ->assertOk();
    }

    public function test_librarian_can_issue_a_book(): void
    {
        $member = Member::factory()->active()->create();
        $book = Book::factory()->create();

        $this->actingAs($this->userWithRole('librarian'))
            ->post(route('admin.borrowings.store'), [
                'member_id' => $member->id,
                'book_id' => $book->id,
            ])
            ->assertRedirect(route('admin.borrowings.index'));

        $this->assertDatabaseHas('borrowings', [
            'member_id' => $member->id,
            'book_id' => $book->id,
        ]);
    }

    public function test_librarian_can_return_a_book(): void
    {
        $member = Member::factory()->active()->create();
        $book = Book::factory()->create();

        $borrowing = Borrowing::factory()->create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'returned_at' => null,
            'status' => 'borrowed',
            'fine_amount' => 0,
        ]);

        $this->actingAs($this->userWithRole('librarian'))
            ->post(route('admin.borrowings.giveBack', $borrowing))
            ->assertRedirect(route('admin.borrowings.index'));

        $this->assertNotNull($borrowing->fresh()->returned_at);
    }

    public function test_member_role_cannot_access_borrowings(): void
    {
        $this->actingAs($this->userWithRole('member'))
            ->get(route('admin.borrowings.index'))
            ->assertForbidden();
    }
}