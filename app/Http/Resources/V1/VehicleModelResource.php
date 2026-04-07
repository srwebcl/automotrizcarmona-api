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
            'thumbnail_url' => $this->thumbnail_url ? (str_starts_with($this->thumbnail_url, 'http') ? $this->thumbnail_url : asset('storage/' . $this->thumbnail_url)) : null,
            'is_hybrid' => (bool) $this->is_hybrid,
            'is_electric' => (bool) $this->is_electric,
            'is_featured' => (bool) $this->is_featured,
            'is_active' => (bool) $this->is_active,
            'desktop_banner_url' => $this->desktop_banner_url ? asset('storage/' . $this->desktop_banner_url) : null,
            'mobile_banner_url' => $this->mobile_banner_url ? asset('storage/' . $this->mobile_banner_url) : null,
            'gallery' => collect($this->gallery ?? [])->map(fn($img) => asset('storage/' . $img))->toArray(),
            'video_url' => $this->video_url,
            'description' => $this->description,
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'versions' => VehicleVersionResource::collection($this->whenLoaded('vehicleVersions')),
            'features' => FeatureResource::collection($this->whenLoaded('features')),
        ];
    }
}
