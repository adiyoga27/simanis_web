<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentRule extends Model
{
    protected $fillable = [
        'title', 'description', 'conditions', 'score_mode',
        'selected_groups', 'result_text', 'color', 'min_score', 'max_score',
        'severity', 'order',
    ];

    protected $casts = [
        'conditions'      => 'array',
        'selected_groups' => 'array',
    ];
}
