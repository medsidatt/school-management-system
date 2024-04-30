<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function studentParents()
    {
        return $this->belongsTo(StudentParent::class, 'id');
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class');
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
