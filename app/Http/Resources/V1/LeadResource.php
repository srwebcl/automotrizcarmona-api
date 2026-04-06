<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'source' => $this->source,
            'customer' => [
                'rut' => $this->rut,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
            ],
            'message' => $this->message,
            'crm_synced' => $this->crm_synced,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
