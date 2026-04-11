<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'type',
        'address',
        'city',
        'manager_name',
        'schedule',
        'phone',
        'email',
        'map_link',
        'image_url'
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
