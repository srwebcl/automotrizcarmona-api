<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckBrand extends Model
{
    protected $fillable = ['name', 'slug', 'logo_url', 'hero_banner_desktop', 'hero_banner_mobile', 'is_active'];

    public function trucks()
    {
        return $this->hasMany(Truck::class);
    }
}
