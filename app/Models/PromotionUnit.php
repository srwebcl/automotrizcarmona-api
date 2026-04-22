<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionUnit extends Model
{
    protected $fillable = [
        'vehicle_model_id',
        'vin',
        'version_name',
        'list_price',
        'promo_bonus',
        'promo_price',
        'status',
        'is_active'
    ];

    protected $casts = [
        'promo_bonus' => 'integer',
        'promo_price' => 'integer',
        'is_active' => 'boolean'
    ];

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }
}
