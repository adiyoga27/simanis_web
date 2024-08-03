<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $table = 'educations';
    protected $fillable = ['education_category_id', 'title','slug', 'content', 'image'];
    
    public function category() {
        return $this->belongsTo(EducationCategory::class, 'education_category_id');
    }
}
