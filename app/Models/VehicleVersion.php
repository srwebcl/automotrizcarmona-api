<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleVersion extends Model
{
    protected $fillable = [
        'vehicle_model_id', 'name', 'transmission', 'traction', 'fuel', 'list_price', 'bonus_price'
    ];

    protected $casts = [
        'list_price' => 'integer',
        'bonus_price' => 'integer',
    ];

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }
}
