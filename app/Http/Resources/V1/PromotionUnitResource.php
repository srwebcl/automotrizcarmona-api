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
            'thumbnail' => $this->thumbnail,
            'version_name' => $this->version_name,
            'list_price' => (int) $this->list_price,
            'promo_bonus' => (int) $this->promo_bonus,
            'promo_price' => (int) $this->promo_price,
            'price_type' => $this->price_type ?? 'financiamiento',
            'status' => $this->status,
            'is_test_car' => (bool) $this->is_test_car,
            'is_active' => (bool) $this->is_active,
        ];
    }
}
