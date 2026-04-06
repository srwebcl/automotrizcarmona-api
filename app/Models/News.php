<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'image', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
