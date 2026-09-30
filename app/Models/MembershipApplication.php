<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipApplication extends Model
{
    //
    protected $fillable = [
        'user_id', 'phone', 'address', 'date_of_birth',
        'emergency_contact_name', 'emergency_contact_phone', 'status',
    ];

    protected $casts = ['date_of_birth' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
