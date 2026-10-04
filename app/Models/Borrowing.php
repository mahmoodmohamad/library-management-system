<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'fine_amount',
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_date' => 'date',
        'returned_at' => 'date',
        'fine_amount' => 'decimal:2',
    ];
public function scopeActive($q)  { return $q->whereNull('returned_at'); }
public function scopeOverdue($q) { return $q->whereNull('returned_at')->whereDate('due_date', '<', today()); }
public function isOverdue(): bool { return $this->returned_at === null && $this->due_date->lt(today()); }
    public function member()
{
    return $this->belongsTo(Member::class)->withTrashed();
}

public function book()
{
    return $this->belongsTo(Book::class)->withTrashed();
}
}