<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FootScreeningResult extends Model
{
    protected $fillable = [
        'user_id',
        'score',
        'risk_level',
        'answers',
        'notes',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
