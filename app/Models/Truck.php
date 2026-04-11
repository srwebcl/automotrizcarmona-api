<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $fillable = ['truck_brand_id', 'name', 'slug', 'image_url', 'is_active', 'category'];

    public function brand()
    {
        return $this->belongsTo(TruckBrand::class, 'truck_brand_id');
    }
}
