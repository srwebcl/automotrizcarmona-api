<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'content' => $this->content,
            'published_at' => $this->published_at ? $this->published_at->toIso8601String() : null,
        ];
    }
}
