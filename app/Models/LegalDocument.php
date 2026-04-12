<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    protected $fillable = [
        'brand_id',
        'title',
        'content',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
