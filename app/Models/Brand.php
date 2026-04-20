<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'name', 'slug', 'logo_url', 'brand_color_css', 'seo_title', 
        'legal_text', 'hero_banners', 'is_active', 'category',
        'show_in_services', 'show_in_parts', 'show_in_dyp',
        'discover_servicio_image', 'discover_repuestos_image',
        'discover_usados_image', 'discover_sucursales_image'
    ];

    protected $casts = [
        'hero_banners' => 'array',
        'is_active' => 'boolean',
        'show_in_services' => 'boolean',
        'show_in_parts' => 'boolean',
        'show_in_dyp' => 'boolean',
    ];

    public function vehicleModels(): HasMany
    {
        return $this->hasMany(VehicleModel::class);
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class);
    }

    public function legalDocuments(): HasMany
    {
        return $this->hasMany(LegalDocument::class);
    }
}
