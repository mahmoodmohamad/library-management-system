<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Member;
use Closure;
use DomainException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait HandlesDomainErrors
{
    protected function attempt(string $key, Closure $action): mixed
    {
        try {
            return $action();
        } catch (DomainException $e) {
            throw ValidationException::withMessages([$key => $e->getMessage()]);
        }
    }

    protected function currentMember(string $key): Member
    {
        return Auth::user()->member
            ?? throw ValidationException::withMessages([$key => 'Your account is not linked to a library member.']);
    }
}