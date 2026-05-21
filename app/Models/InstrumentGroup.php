<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstrumentGroup extends Model
{
    protected $fillable = ['title', 'description', 'order'];

    public function questions(): HasMany
    {
        return $this->hasMany(InstrumentQuestion::class)->orderBy('order');
    }
}
