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
        'active',
        'location',
        'custom_data'
    ];

    protected $casts = [
        'active' => 'boolean',
        'custom_data' => 'array',
    ];
}
