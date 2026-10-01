<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;

class MemberPolicy
{
    public function viewAny(User $user): bool { return $user->hasRole('admin', 'librarian'); }
    public function view(User $user, Member $member): bool { return $user->hasRole('admin', 'librarian'); }
    public function create(User $user): bool { return $user->hasRole('admin', 'librarian'); }
    public function update(User $user, Member $member): bool { return $user->hasRole('admin', 'librarian'); }
    public function delete(User $user, Member $member): bool { return $user->hasRole('admin'); }
}