<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'book_id', 'status', 'fulfilled_at'];
public const ACTIVE = 'active';
public const FULFILLED = 'fulfilled';
public const CANCELLED = 'cancelled';
public const EXPIRED = 'expired'; // reserved for a future hold-window feature
    protected $casts = ['fulfilled_at' => 'datetime'];

    public function member()
    {
        return $this->belongsTo(Member::class)->withTrashed();
    }

    public function book()
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}