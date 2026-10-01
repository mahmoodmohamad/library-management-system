<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Book extends Model
{
    use HasFactory, SoftDeletes;

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
        'category_id',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'pages' => 'integer',
        'available_quantity' => 'integer',
        'total_copies' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function authors()
    {
        return $this->belongsToMany(
            Author::class,
            'author_book'
        );
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
    public function reservations()
{
    return $this->hasMany(Reservation::class);
}
}