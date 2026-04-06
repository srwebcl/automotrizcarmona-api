<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image_desktop',
        'image_mobile',
        'link',
        'order',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
