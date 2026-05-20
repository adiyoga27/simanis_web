<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentRule extends Model
{
    protected $fillable = ['title', 'description', 'conditions', 'result_text', 'severity', 'order'];

    protected $casts = [
        'conditions' => 'array',
    ];
}
