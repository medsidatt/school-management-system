<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    protected $fillable = [
        'rim',
        'first_name',
        'last_name',
        'sex',
        'parent',
        'class',
        'date_of_birth'
    ];
}
