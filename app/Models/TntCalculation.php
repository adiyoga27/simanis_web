<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TntCalculation extends Model
{
    protected $fillable = [
        'user_id',
        'jk',
        'height',
        'weight',
        'age',
        'activity',
        'weight_status',
        'bmi',
        'bbi',
        'calorie_needs',
        'diet_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function diet(): BelongsTo
    {
        return $this->belongsTo(Diet::class);
    }
}
