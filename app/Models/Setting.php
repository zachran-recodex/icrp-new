<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'address',
        'phone',
        'email',
        'social_links',
        'footer_text',
        'logo',
        'favicon',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    public static function getSettings()
    {
        return static::first() ?? static::create([]);
    }

    public function getSocialLink(string $platform): ?string
    {
        return $this->social_links[$platform] ?? null;
    }

    public function setSocialLink(string $platform, string $url): void
    {
        $socialLinks = $this->social_links ?? [];
        $socialLinks[$platform] = $url;
        $this->social_links = $socialLinks;
        $this->save();
    }
}
