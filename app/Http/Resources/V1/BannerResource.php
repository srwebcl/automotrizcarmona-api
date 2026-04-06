<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'image_desktop' => $this->image_desktop ? asset('storage/' . $this->image_desktop) : null,
            'image_mobile' => $this->image_mobile ? asset('storage/' . $this->image_mobile) : null,
            'link' => $this->link,
            'order' => $this->order,
            'active' => (bool)$this->active
        ];
    }
}
