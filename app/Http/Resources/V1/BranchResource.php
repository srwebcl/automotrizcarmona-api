<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imageUrl = null;
        if ($this->image_url) {
            // If already a full URL, use it; otherwise prefix with R2 CDN
            $imageUrl = str_starts_with($this->image_url, 'http')
                ? $this->image_url
                : 'https://pub-5f17f36d654d46e6a6a748a95586b21f.r2.dev/' . ltrim($this->image_url, '/');
        }

        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'type'         => $this->type,
            'address'      => $this->address,
            'city'         => $this->city,
            'manager_name' => $this->manager_name,
            'schedule'     => $this->schedule,
            'phone'        => $this->phone,
            'email'        => $this->email,
            'map_link'     => $this->map_link,
            'image_url'    => $imageUrl,
            'brands_list'  => $this->brands_list ?? [],
        ];
    }
}
