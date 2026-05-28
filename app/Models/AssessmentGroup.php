<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentGroup extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'image', 'icon', 'order'];

    public function subGroups(): HasMany
    {
        return $this->hasMany(AssessmentSubGroup::class)->orderBy('order');
    }
}
