<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medication extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'dosis',
        'date_at',
        'time_at',
        'duration',
        'is_active',
    ];

    protected $casts = [
        'date_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
