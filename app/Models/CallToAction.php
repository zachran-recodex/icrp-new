<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallToAction extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'button_text',
    ];
}
