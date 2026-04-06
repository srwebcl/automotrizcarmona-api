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
            'list_price' => (int) $this->list_price,
            'bonus_price' => (int) $this->bonus_price,
            'final_price' => (int) ($this->list_price - $this->bonus_price),
        ];
    }
}
