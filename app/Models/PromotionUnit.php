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

    protected static function booted()
    {
        // Al crear o guardar una unidad, activar la promoción en el modelo padre automáticamente
        static::saved(function ($promotionUnit) {
            if ($promotionUnit->is_active && $promotionUnit->vehicleModel) {
                if (!$promotionUnit->vehicleModel->is_promotion) {
                    $promotionUnit->vehicleModel->update(['is_promotion' => true]);
                }
            }
        });

        // Opcional y muy útil: Al borrar una unidad, si ya no le quedan más unidades, apagar la promoción
        static::deleted(function ($promotionUnit) {
            if ($promotionUnit->vehicleModel) {
                $activeCount = PromotionUnit::where('vehicle_model_id', $promotionUnit->vehicle_model_id)
                    ->where('is_active', true)
                    ->count();
                
                if ($activeCount === 0) {
                    $promotionUnit->vehicleModel->update(['is_promotion' => false]);
                }
            }
        });
    }
}
