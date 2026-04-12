<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormRecipient extends Model
{
    protected $fillable = [
        'identifier',
        'name',
        'emails',
    ];

    protected $casts = [
        'emails' => 'array',
    ];
}
