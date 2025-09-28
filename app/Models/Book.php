<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'title',
        'isbn',
        'publisher_id',
        'description',
        'publication_year',
        'pages',
        'available_quantity',
        'total_copies',
        'shelf_location',
        'category_id'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_book');

    }
  public function borrowings()
{
    return $this->hasMany(Borrowing::class);
}

}

