<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Library extends Model
{
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'author',
        'description',
        'image',
        'publisher',
        'publication_year',
        'isbn',
        'category',
        'page_count',
        'language',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'page_count' => 'integer',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(LibraryComment::class)->latest();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(LibraryReview::class)->latest();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByAuthor($query, string $author)
    {
        return $query->where('author', 'like', "%{$author}%");
    }

    public function scopeByLanguage($query, string $language)
    {
        return $query->where('language', $language);
    }
}
