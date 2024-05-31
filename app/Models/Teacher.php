<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_teachers');
    }
    public function subjects()
    {
        return $this->belongsToMany(Subjects::class, 'teacher_subjects')
            ->withPivot('time')
            ->withTimestamps();
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
