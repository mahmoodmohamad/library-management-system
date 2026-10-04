<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Member;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogueTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_by_title(): void
    {
        Book::factory()->create(['title' => 'Clean Code']);
        Book::factory()->create(['title' => 'Refactoring']);

        $this->get(route('books.index', ['search' => 'Clean']))
            ->assertOk()->assertSee('Clean Code')->assertDontSee('Refactoring');
    }

    public function test_search_by_isbn(): void
    {
        Book::factory()->create(['title' => 'Alpha Book', 'isbn' => '9780132350884']);
        Book::factory()->create(['title' => 'Beta Book', 'isbn' => '9781491950296']);

        $this->get(route('books.index', ['search' => '9780132350884']))
            ->assertSee('Alpha Book')->assertDontSee('Beta Book');
    }

    public function test_search_by_author(): void
    {
        $author = Author::factory()->create(['name' => 'Robert Martin']);
        Book::factory()->create(['title' => 'Alpha Book'])->authors()->attach($author);
        Book::factory()->create(['title' => 'Beta Book']);

        $this->get(route('books.index', ['search' => 'Martin']))
            ->assertSee('Alpha Book')->assertDontSee('Beta Book');
    }

    public function test_filter_by_category(): void
    {
        $cat = Category::factory()->create();
        Book::factory()->create(['title' => 'In Category', 'category_id' => $cat->id]);
        Book::factory()->create(['title' => 'Other Category']);

        $this->get(route('books.index', ['category' => $cat->id]))
            ->assertSee('In Category')->assertDontSee('Other Category');
    }

    public function test_filter_by_availability(): void
    {
        Book::factory()->create(['title' => 'Here Book', 'available_quantity' => 3]);
        Book::factory()->create(['title' => 'Gone Book', 'available_quantity' => 0]);

        $this->get(route('books.index', ['availability' => 'available']))
            ->assertSee('Here Book')->assertDontSee('Gone Book');
        $this->get(route('books.index', ['availability' => 'unavailable']))
            ->assertSee('Gone Book')->assertDontSee('Here Book');
    }

    public function test_pagination_preserves_filters(): void
    {
        $cat = Category::factory()->create();
        Book::factory()->count(13)->create(['category_id' => $cat->id]);

        $this->get(route('books.index', ['category' => $cat->id]))
            ->assertSee('page=2', false)
            ->assertSee('category='.$cat->id, false);
    }

    // ---- book details states ----

    private function memberUser(array $member = []): array
    {
        $user = User::factory()->create();
        $m = Member::factory()->active()->create(['email' => $user->email] + $member);

        return [$user, $m];
    }

    public function test_guest_sees_sign_in(): void
    {
        $this->get(route('books.show', Book::factory()->create()))->assertSee('Sign in to borrow');
    }

    public function test_user_without_member_sees_membership_required(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('books.show', Book::factory()->create()))
            ->assertSee('Membership required');
    }

    public function test_member_can_borrow_available_book(): void
    {
        [$user] = $this->memberUser();

        $this->actingAs($user)->get(route('books.show', Book::factory()->create()))->assertSee('Borrow book');
    }

    public function test_member_with_active_loan_sees_return(): void
    {
        [$user, $member] = $this->memberUser();
        $book = Book::factory()->create();
        Borrowing::factory()->create([
            'member_id' => $member->id, 'book_id' => $book->id, 'borrowed_at' => today(),
            'due_date' => today()->addDays(5), 'returned_at' => null, 'status' => 'borrowed', 'fine_amount' => 0,
        ]);

        $this->actingAs($user)->get(route('books.show', $book))->assertSee('Return book');
    }

    public function test_unavailable_book_can_be_reserved_then_cancelled(): void
    {
        [$user, $member] = $this->memberUser();
        $book = Book::factory()->create(['available_quantity' => 0]);

        $this->actingAs($user)->get(route('books.show', $book))->assertSee('Reserve book');

        Reservation::create(['member_id' => $member->id, 'book_id' => $book->id, 'status' => 'active']);
        $this->actingAs($user)->get(route('books.show', $book))->assertSee('Cancel reservation');
    }

    public function test_suspended_member_sees_inactive_notice(): void
    {
        [$user] = $this->memberUser(['status' => 'suspended']);

        $this->actingAs($user)->get(route('books.show', Book::factory()->create()))
            ->assertSee('Membership not active');
    }

    // ---- authorization ----

    public function test_member_cannot_open_admin(): void
    {
        $this->actingAs(User::factory()->create())->get('/admin/borrowings')->assertForbidden();
    }

    public function test_librarian_cannot_delete_book(): void
    {
        $book = Book::factory()->create();

        $this->actingAs(User::factory()->librarian()->create())
            ->delete(route('admin.books.destroy', $book))->assertForbidden();
    }

    // ---- reservation queue ----

    public function test_reserved_copy_is_held_for_first_in_queue(): void
    {
        $book = Book::factory()->create(['available_quantity' => 1]);
        $first = Member::factory()->active()->create();
        $other = Member::factory()->active()->create();
        Reservation::create(['member_id' => $first->id, 'book_id' => $book->id, 'status' => 'active']);

        $service = app(\App\Services\BorrowingService::class);

        $this->expectException(\DomainException::class);
        $service->borrow($other, $book);
    }
}