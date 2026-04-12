<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Landing extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'desktop_banner_url',
        'mobile_banner_url',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
