<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'subject_id', 'quarter', 'note'];

    public function subjects()
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }

    public function students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
