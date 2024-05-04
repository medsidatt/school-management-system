<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subjects extends Model
{

    use HasFactory;
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class, 'class_subjects', 'subject', 'class');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
