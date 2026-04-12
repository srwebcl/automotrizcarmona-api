<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckBrand extends Model
{
    protected $fillable = [
        'name', 'slug', 'logo_url', 'hero_banner_desktop', 
        'hero_banner_mobile', 'is_active',
        'show_in_services', 'show_in_parts', 'show_in_dyp'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_services' => 'boolean',
        'show_in_parts' => 'boolean',
        'show_in_dyp' => 'boolean',
    ];

    public function trucks()
    {
        return $this->hasMany(Truck::class);
    }

    public function legalDocuments()
    {
        return $this->hasMany(LegalDocument::class);
    }
}
