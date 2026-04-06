<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'source', 'rut', 'name', 'email', 'phone', 
        'vehicle_id', 'service_type', 'message', 
        'raw_request', 'crm_synced'
    ];

    protected $casts = [
        'crm_synced' => 'boolean',
        'raw_request' => 'array',
    ];
}
