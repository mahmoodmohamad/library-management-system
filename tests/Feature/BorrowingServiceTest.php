<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Services\BorrowingService;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowingServiceTest extends TestCase
{
    use RefreshDatabase;

    private BorrowingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BorrowingService();
    }

    public function test_borrowing_decrements_stock_and_creates_record(): void
    {
        $member = Member::factory()->active()->create();
        $book = Book::factory()->create(['available_quantity' => 3, 'total_copies' => 3]);

        $borrowing = $this->service->borrow($member, $book);

        $this->assertSame('borrowed', $borrowing->status);
        $this->assertEquals(today()->addDays(14), $borrowing->due_date);
        $this->assertSame(2, $book->fresh()->available_quantity);
    }

    public function test_cannot_borrow_when_no_copies_available(): void
    {
        $member = Member::factory()->active()->create();
        $book = Book::factory()->create(['available_quantity' => 0, 'total_copies' => 3]);

        $this->expectException(DomainException::class);

        $this->service->borrow($member, $book);
    }

    public function test_suspended_member_cannot_borrow(): void
    {
        $member = Member::factory()->suspended()->create();
        $book = Book::factory()->create(['available_quantity' => 3, 'total_copies' => 3]);

        $this->expectException(DomainException::class);

        $this->service->borrow($member, $book);
    }

    public function test_return_on_time_restores_stock_without_fine(): void
    {
        $member = Member::factory()->active()->create(['outstanding_fines' => 0]);
        $book = Book::factory()->create(['available_quantity' => 3, 'total_copies' => 3]);

        $borrowing = $this->service->borrow($member, $book);
        $returned = $this->service->returnBook($borrowing);

        $this->assertSame('returned', $returned->status);
        $this->assertSame('0.00', $returned->fine_amount);
        $this->assertSame(3, $book->fresh()->available_quantity);
    }

    public function test_late_return_charges_fine_per_day(): void
    {
        $member = Member::factory()->active()->create(['outstanding_fines' => 0]);
        $book = Book::factory()->create(['available_quantity' => 2, 'total_copies' => 3]);

        $borrowing = Borrowing::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrowed_at' => today()->subDays(17),
            'due_date' => today()->subDays(3),
            'status' => 'borrowed',
            'fine_amount' => 0,
        ]);

        $returned = $this->service->returnBook($borrowing);

        $this->assertSame('15.00', $returned->fine_amount);
        $this->assertSame('15.00', $member->fresh()->outstanding_fines);
        $this->assertSame(3, $book->fresh()->available_quantity);
    }
}