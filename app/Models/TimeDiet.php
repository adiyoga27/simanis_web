<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeDiet extends Model
{
    use HasFactory;
    protected $fillable = [
        'diet_id',
        'title'
    ];

    protected $casts = [
        'diet_id' => 'integer'
    ];

    function food() {
        return $this->hasMany(FoodDiet::class, 'time_id', 'id');
    }
}
