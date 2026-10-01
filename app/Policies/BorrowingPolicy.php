<?php

namespace App\Policies;

use App\Models\Borrowing;
use App\Models\User;

class BorrowingPolicy
{
    public function viewAny(User $user): bool { return $user->hasRole('admin', 'librarian'); }
    public function create(User $user): bool { return $user->hasRole('admin', 'librarian'); }
    public function update(User $user, Borrowing $borrowing): bool { return $user->hasRole('admin', 'librarian'); }
}