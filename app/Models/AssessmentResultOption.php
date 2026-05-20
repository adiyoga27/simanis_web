<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentResultOption extends Model
{
    protected $fillable = ['assessment_result_id', 'assessment_option_id', 'assessment_group_id', 'assessment_sub_group_id'];

    public $timestamps = false;

    public function result(): BelongsTo
    {
        return $this->belongsTo(AssessmentResult::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(AssessmentOption::class, 'assessment_option_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(AssessmentGroup::class, 'assessment_group_id');
    }

    public function subGroup(): BelongsTo
    {
        return $this->belongsTo(AssessmentSubGroup::class, 'assessment_sub_group_id');
    }
}
