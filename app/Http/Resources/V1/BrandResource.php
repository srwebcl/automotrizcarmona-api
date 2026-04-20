<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'logo_url' => $this->logo_url ? asset('storage/' . $this->logo_url) : null,
            'brand_color_css' => $this->brand_color_css,
            'seo_title' => $this->seo_title,
            'legal_text' => $this->legal_text,
            'hero_banners' => collect($this->hero_banners ?? [])->map(fn($b) => [
                'title' => $b['title'] ?? '',
                'desktop_image' => isset($b['desktop_image']) ? asset('storage/' . $b['desktop_image']) : null,
                'mobile_image' => isset($b['mobile_image']) ? asset('storage/' . $b['mobile_image']) : null,
            ]),
            'is_active' => (bool)$this->is_active,
            'category' => $this->category,
            'show_in_services' => (bool)$this->show_in_services,
            'show_in_parts' => (bool)$this->show_in_parts,
            'show_in_dyp' => (bool)$this->show_in_dyp,
            'discover_servicio_image' => $this->discover_servicio_image,
            'discover_repuestos_image' => $this->discover_repuestos_image,
            'discover_usados_image' => $this->discover_usados_image,
            'discover_sucursales_image' => $this->discover_sucursales_image,
        ];
    }
}
