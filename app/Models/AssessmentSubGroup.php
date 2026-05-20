<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentSubGroup extends Model
{
    protected $fillable = ['assessment_group_id', 'title', 'description', 'order'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(AssessmentGroup::class, 'assessment_group_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(AssessmentOption::class)->orderBy('order');
    }
}
