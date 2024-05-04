<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;
    protected $table = 'parents';
    public function students()
    {
        return $this->hasMany(Student::class, 'id');
    }

    protected $fillable = [
      'nni',
      'first_name',
      'last_name',
      'tel',
      'sex',
      'date_of_birth'
    ];
}
