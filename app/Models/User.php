<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function member() { return $this->hasOne(Member::class); }
    
    public function membershipApplication()
{
    return $this->hasOne(MembershipApplication::class);
}
public function hasRole(string ...$roles): bool
{
    return in_array($this->role?->name, $roles, true);
}
public function isBackOffice(): bool
{
    return $this->hasRole('admin', 'librarian', 'staff');
}
}