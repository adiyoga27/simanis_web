<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
    ];

    public function time()
    {
        return $this->hasMany(TimeDiet::class, 'diet_id', 'id');
    }
}
