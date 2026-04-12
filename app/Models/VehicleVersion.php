<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleVersion extends Model
{
    protected $fillable = [
        'vehicle_model_id', 'name', 'transmission', 'traction', 'fuel', 
        'motor', 'power', 'torque', 'consumption_mixed', 'electric_range',
        'list_price', 'finance_price', 'brand_bonus', 'finance_bonus',
        'includes_iva', 'airbags'
    ];

    protected $casts = [
        'list_price' => 'integer',
        'finance_price' => 'integer',
        'brand_bonus' => 'integer',
        'finance_bonus' => 'integer',
        'includes_iva' => 'boolean',
        'airbags' => 'integer',
    ];

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    protected static function booted()
    {
        static::saving(function ($version) {
            $brandBonus = $version->brand_bonus ?? 0;
            $financeBonus = $version->finance_bonus ?? 0;
            $version->finance_price = max(0, ($version->list_price ?? 0) - $brandBonus - $financeBonus);
        });
    }
}
