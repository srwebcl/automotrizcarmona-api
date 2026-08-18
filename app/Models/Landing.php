<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Landing extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'badge_text',
        'badge_logo_url',
        'desktop_banner_url',
        'mobile_banner_url',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function legalDocuments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(LegalDocument::class, 'legalable');
    }
}
