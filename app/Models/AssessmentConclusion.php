<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentConclusion extends Model
{
    protected $fillable = [
        'title', 'description', 'result_text', 'reference_link',
        'color', 'severity', 'priority', 'order',
    ];

    public function conditions(): HasMany
    {
        return $this->hasMany(AssessmentConclusionCondition::class, 'conclusion_id');
    }
}
