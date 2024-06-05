<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $fillable = [
        'name'
    ];



    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class');
    }
    public function timetables(): HasMany
    {
        return $this->hasMany(Timetable::class, 'class_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subjects::class, 'class_subjects', 'class', 'subject')
            ->withPivot('hour')
            ->withPivot('coefficient')
            ->withTimestamps();
    }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_teachers')->withTimestamps();
    }

}
