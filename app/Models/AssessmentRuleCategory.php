<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentRuleCategory extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'order'];

    public function rules(): HasMany
    {
        return $this->hasMany(AssessmentRule::class, 'rule_category_id');
    }
}
