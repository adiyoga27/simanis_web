<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title','slug'];


    function educations() {
        return $this->hasMany(Education::class, 'education_category_id', 'id'  );
    }
}
