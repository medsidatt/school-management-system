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

    /*protected $with = [
        'students',
        'subjects'
    ];*/

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subjects::class, 'class_subjects', 'class', 'subject');
    }


}
