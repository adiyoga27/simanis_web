<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentRule extends Model
{
    protected $fillable = [
        'rule_category_id', 'title', 'description', 'conditions', 'score_mode',
        'selected_groups', 'result_text', 'reference_link', 'color', 'min_score', 'max_score',
        'severity', 'order',
    ];

    protected $casts = [
        'conditions'      => 'array',
        'selected_groups' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AssessmentRuleCategory::class, 'rule_category_id');
    }
}
