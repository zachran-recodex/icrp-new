<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryReview extends Model
{
    protected $fillable = [
        'library_id',
        'reviewer',
        'review',
    ];

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }
}
