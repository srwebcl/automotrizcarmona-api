<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleVersionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'transmission' => $this->transmission,
            'traction' => $this->traction,
            'fuel' => $this->fuel,
            'motor' => $this->engine,
            'consumption_mixed' => $this->mixed_performance,
            'electric_range' => $this->autonomy_km,
            'power' => $this->power_hp,
            'torque' => $this->torque_nm,
            'list_price' => (int) $this->list_price,
            'brand_bonus' => (int) $this->brand_bonus,
            'financing_bonus' => (int) $this->finance_bonus,
            'final_price' => (int) $this->finance_price,
            'airbags' => $this->airbags,
            'includes_iva' => $this->includes_iva,
        ];
    }
}
