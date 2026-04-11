<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Brand;
use App\Models\TruckBrand;

class Branch extends Model
{
    protected $fillable = [
        'name', 'type', 'address', 'city', 'manager_name',
        'schedule', 'phone', 'email', 'map_link', 'image_url', 'brands_list'
    ];

    protected $casts = [
        'brands_list' => 'array',
    ];

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class);
    }

    public function truckBrands(): BelongsToMany
    {
        return $this->belongsToMany(TruckBrand::class, 'branch_truck_brand');
    }
}
