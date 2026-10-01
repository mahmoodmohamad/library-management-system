<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\Reservation;
use App\Services\ReservationService;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationServiceTest extends TestCase
{
    use RefreshDatabase;

    private function unavailableBook(): Book
    {
        return Book::factory()->create(['total_copies' => 1, 'available_quantity' => 0]);
    }

    public function test_member_can_reserve_unavailable_book(): void
    {
        $member = Member::factory()->active()->create();
        $book = $this->unavailableBook();

        $reservation = app(ReservationService::class)->reserve($member, $book);

        $this->assertSame('active', $reservation->status);
        $this->assertSame(0, $book->fresh()->available_quantity);
    }

    public function test_cannot_reserve_available_book(): void
    {
        $this->expectException(DomainException::class);

        app(ReservationService::class)->reserve(
            Member::factory()->active()->create(),
            Book::factory()->create()
        );
    }

    public function test_cannot_reserve_twice(): void
    {
        $member = Member::factory()->active()->create();
        $book = $this->unavailableBook();
        $service = app(ReservationService::class);

        $service->reserve($member, $book);

        $this->expectException(DomainException::class);
        $service->reserve($member, $book);
    }

    public function test_suspended_member_cannot_reserve(): void
    {
        $this->expectException(DomainException::class);

        app(ReservationService::class)->reserve(
            Member::factory()->suspended()->create(),
            $this->unavailableBook()
        );
    }

    public function test_member_holding_the_book_cannot_reserve_it(): void
    {
        $member = Member::factory()->active()->create();
        $book = $this->unavailableBook();

        Borrowing::factory()->create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'returned_at' => null,
            'status' => 'borrowed',
            'fine_amount' => 0,
        ]);

        $this->expectException(DomainException::class);
        app(ReservationService::class)->reserve($member, $book);
    }
}