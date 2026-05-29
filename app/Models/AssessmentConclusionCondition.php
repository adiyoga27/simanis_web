<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentConclusionCondition extends Model
{
    protected $fillable = ['conclusion_id', 'rule_category_id', 'min_matched_rules', 'target_severity'];

    public function conclusion(): BelongsTo
    {
        return $this->belongsTo(AssessmentConclusion::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AssessmentRuleCategory::class, 'rule_category_id');
    }
}
