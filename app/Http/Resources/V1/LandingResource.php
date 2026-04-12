<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LandingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'desktop_banner_url' => $this->desktop_banner_url ? (str_starts_with($this->desktop_banner_url, 'http') ? $this->desktop_banner_url : 'https://pub-5f17f36d654d46e6a6a748a95586b21f.r2.dev/' . ltrim($this->desktop_banner_url, '/')) : null,
            'mobile_banner_url' => $this->mobile_banner_url ? (str_starts_with($this->mobile_banner_url, 'http') ? $this->mobile_banner_url : 'https://pub-5f17f36d654d46e6a6a748a95586b21f.r2.dev/' . ltrim($this->mobile_banner_url, '/')) : null,
            'is_active' => (bool) $this->is_active,
        ];
    }
}
