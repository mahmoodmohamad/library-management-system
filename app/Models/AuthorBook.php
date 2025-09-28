<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorBook extends Model
{
    //
    use HasFactory;

     protected $table = 'author_book'; // pivot table
    protected $fillable = ['book_id', 'author_id'];
}
