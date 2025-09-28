<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    //
    use HasFactory;
    protected $fillable=['member_id', 'book_id','borrowed_at', 'due_date', 'returned_at','status', 'fine_amount'];
   public function member()
{
    return $this->belongsTo(Member::class);
}
public function book()
{
    return $this->belongsTo(Book::class);
}
}