<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_teachers')->withTimestamps();
    }
    public function subjects()
    {
        return $this->belongsToMany(Subjects::class, 'teacher_subjects')
            ->withTimestamps();
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'sex',
        'date_of_birth',
        'nni',
        'img_path'
    ];
}
