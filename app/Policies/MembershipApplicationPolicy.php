<?php

namespace App\Policies;

use App\Models\MembershipApplication;
use App\Models\User;

class MembershipApplicationPolicy
{
    public function viewAny(User $user): bool { return $user->hasRole('admin', 'librarian'); }
    public function update(User $user, MembershipApplication $application): bool { return $user->hasRole('admin', 'librarian'); }
}