<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'member_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'membership_type',
        'membership_start_date',
        'membership_expiry_date',
        'emergency_contact_name',
        'emergency_contact_phone',
        'status',
        'outstanding_fines',
        'notes',
    ];


  public function borrowings()
{
    return $this->hasMany(Borrowing::class);
}
    public function books()
{
    return $this->belongsToMany(Book::class, 'borrowings');
}
}
