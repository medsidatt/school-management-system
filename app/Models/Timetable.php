<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;
    protected $table = 'timetables';

    protected $fillable = [
        'day',
        'subject_id',
        'teacher_id',
        'classes_id',
        'start',
        'end',
    ];

    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }
    public function subjects()
    {
        return $this->belongsTo(Subjects::class);
    }
    public function teachers()
    {
        return $this->belongsTo(Teacher::class);
    }
}
