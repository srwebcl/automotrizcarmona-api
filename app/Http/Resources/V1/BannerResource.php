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
            'image_desktop' => $this->image_desktop,
            'image_mobile' => $this->image_mobile,
            'link' => $this->link,
            'order' => $this->order,
            'location' => $this->location,
            'custom_data' => $this->custom_data,
            'active' => (bool)$this->active
        ];
    }
}
