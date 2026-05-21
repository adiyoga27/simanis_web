<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstrumentResult extends Model
{
    protected $fillable = ['user_id', 'total_score', 'max_score', 'percentage', 'interpretation', 'answers'];

    protected $casts = [
        'answers' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
