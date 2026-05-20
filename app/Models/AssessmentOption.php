<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentOption extends Model
{
    protected $fillable = ['assessment_sub_group_id', 'text', 'image', 'score', 'order'];

    public function subGroup(): BelongsTo
    {
        return $this->belongsTo(AssessmentSubGroup::class, 'assessment_sub_group_id');
    }
}
