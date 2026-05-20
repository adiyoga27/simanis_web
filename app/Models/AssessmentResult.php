<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentResult extends Model
{
    protected $fillable = ['user_id', 'total_score', 'group_scores', 'matched_rules', 'notes'];

    protected $casts = [
        'group_scores' => 'array',
        'matched_rules' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resultOptions(): HasMany
    {
        return $this->hasMany(AssessmentResultOption::class);
    }
}
