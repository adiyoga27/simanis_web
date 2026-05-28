<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstrumentQuestion extends Model
{
    protected $fillable = ['instrument_group_id', 'question', 'score_type', 'order'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(InstrumentGroup::class, 'instrument_group_id');
    }
}
