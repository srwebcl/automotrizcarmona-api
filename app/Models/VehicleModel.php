<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleModel extends Model
{
    protected $fillable = [
        'brand_id', 'name', 'slug', 'category', 'thumbnail_url', 'desktop_banner_url', 
        'mobile_banner_url', 'video_url', 'gallery', 'base_price', 'slogan', 
        'is_new', 'is_hybrid', 'is_electric', 'is_commercial', 'vehicle_type', 'is_promotion'
    ];

    protected $casts = [
        'gallery' => 'array',
        'category' => 'array',
        'is_new' => 'boolean',
        'is_hybrid' => 'boolean',
        'is_electric' => 'boolean',
        'is_commercial' => 'boolean',
        'is_promotion' => 'boolean',
        'base_price' => 'integer',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function vehicleVersions(): HasMany
    {
        return $this->hasMany(VehicleVersion::class);
    }

    public function promotionUnits(): HasMany
    {
        return $this->hasMany(PromotionUnit::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(Feature::class);
    }
}
