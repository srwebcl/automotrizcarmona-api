<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleModelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'slogan' => $this->slogan,
            'category' => $this->category,
            'vehicle_type' => $this->vehicle_type ?? 'auto',
            'base_price' => (int) ($this->base_price ?? ($this->relationLoaded('vehicleVersions') ? $this->vehicleVersions->min('list_price') : 0)),
            'thumbnail_url' => $this->thumbnail_url ? (str_starts_with($this->thumbnail_url, 'http') ? $this->thumbnail_url : 'https://pub-5f17f36d654d46e6a6a748a95586b21f.r2.dev/' . ltrim($this->thumbnail_url, '/')) : null,
            'is_hybrid' => (bool) $this->is_hybrid,
            'is_electric' => (bool) $this->is_electric,
            'is_featured' => (bool) $this->is_featured,
            'is_active' => (bool) $this->is_active,
            'is_promotion' => (bool) $this->is_promotion,
            'includes_iva' => (bool) ($this->includes_iva ?? true),
            'promotion_units' => PromotionUnitResource::collection($this->whenLoaded('promotionUnits')),
            'desktop_banner_url' => $this->desktop_banner_url ? (str_starts_with($this->desktop_banner_url, 'http') ? $this->desktop_banner_url : 'https://pub-5f17f36d654d46e6a6a748a95586b21f.r2.dev/' . ltrim($this->desktop_banner_url, '/')) : null,
            'mobile_banner_url' => $this->mobile_banner_url ? (str_starts_with($this->mobile_banner_url, 'http') ? $this->mobile_banner_url : 'https://pub-5f17f36d654d46e6a6a748a95586b21f.r2.dev/' . ltrim($this->mobile_banner_url, '/')) : null,
            'gallery' => collect(array_reverse($this->gallery ?? []))->map(fn($img) => str_starts_with($img, 'http') ? $img : 'https://pub-5f17f36d654d46e6a6a748a95586b21f.r2.dev/' . ltrim($img, '/'))->toArray(),
            'video_url' => $this->video_url,
            'description' => $this->description,
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'versions' => VehicleVersionResource::collection($this->whenLoaded('vehicleVersions')),
            'features' => FeatureResource::collection($this->whenLoaded('features')),
        ];
    }
}
