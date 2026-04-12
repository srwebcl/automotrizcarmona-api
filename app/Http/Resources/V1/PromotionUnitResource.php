<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionUnitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vin' => $this->vin,
            'version_name' => $this->version_name,
            'promo_bonus' => (int) $this->promo_bonus,
            'promo_price' => (int) $this->promo_price,
            'is_active' => (bool) $this->is_active,
        ];
    }
}
