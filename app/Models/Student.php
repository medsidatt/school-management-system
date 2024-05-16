<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

//    public function parents()
//    {
//        return $this->belongsTo(StudentParent::class, 'parent');
//    }

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
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
