<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodDiet extends Model
{
    use HasFactory;
    protected $fillable = [
        'time_id',
        'material',
        'unit',
        'menu'
    ];
    protected $casts = [
        'time_id' => 'integer'
    ];
}
