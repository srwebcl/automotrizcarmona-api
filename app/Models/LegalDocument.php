<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    protected $fillable = [
        'brand_id',
        'truck_brand_id',
        'title',
        'excerpt',
        'content',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function truckBrand()
    {
        return $this->belongsTo(TruckBrand::class);
    }
}
