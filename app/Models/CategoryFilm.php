<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryFilm extends Model
{
    public $timestamps = false;

    protected $fillable = ['category_id', 'film_id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }
}