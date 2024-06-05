<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subjects extends Model
{

    use HasFactory;
    protected $fillable = ['name', 'code'];
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class, 'class_subjects', 'subject', 'class');
    }
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subjects');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }
}
