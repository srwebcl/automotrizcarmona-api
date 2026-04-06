<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'address' => $this->address,
            'city' => $this->city,
            'manager_name' => $this->manager_name,
            'schedule' => $this->schedule,
            'phone' => $this->phone,
            'email' => $this->email,
            'map_link' => $this->map_link,
            'image_url' => $this->image_url ? asset('storage/' . $this->image_url) : null,
            'brands' => BrandResource::collection($this->whenLoaded('brands')),
        ];
    }
}
