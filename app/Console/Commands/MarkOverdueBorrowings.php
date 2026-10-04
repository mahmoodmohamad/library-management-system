<?php

namespace App\Console\Commands;

use App\Models\Borrowing;
use Illuminate\Console\Command;

class MarkOverdueBorrowings extends Command
{
    protected $signature = 'library:mark-overdue';
    protected $description = 'Flag active borrowings past their due date as overdue';

    public function handle(): int
    {
        $n = Borrowing::overdue()->where('status', 'borrowed')->update(['status' => 'overdue']);
        $this->info("Marked {$n} borrowings as overdue.");

        return self::SUCCESS;
    }
}