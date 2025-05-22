<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'nickname',
        'slug',
        'birth_date',
        'death_date',
        'birth_place',
        'known_as',
        'quote',
        'biography',
        'image',
        'order',
        'position',
        'dewan',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
        'order' => 'integer',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(MemberContribution::class)->orderBy('order');
    }

    public function legacies(): HasMany
    {
        return $this->hasMany(MemberLegacy::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFullNameAttribute(): string
    {
        return $this->nickname ? "{$this->name} ({$this->nickname})" : $this->name;
    }

    public function getIsAliveAttribute(): bool
    {
        return is_null($this->death_date);
    }

    public function scopeByDewan($query, string $dewan)
    {
        return $query->where('dewan', $dewan);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }
}
