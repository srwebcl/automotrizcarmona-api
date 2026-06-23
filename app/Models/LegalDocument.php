<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    protected $fillable = [
        'legalable_id',
        'legalable_type',
        'title',
        'content',
    ];

    public function legalable()
    {
        return $this->morphTo();
    }
}
