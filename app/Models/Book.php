<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'image',
        'category_id',
        'isbn'
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    protected static function BookFactory(): Factory
{
    return BookFactory::new();
}
}
