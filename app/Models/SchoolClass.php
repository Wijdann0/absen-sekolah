<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name', 'grade', 'homeroom_teacher_id',
    ];

    public function homeroomTeacher()
    {
        return $this->belongsTo(Teacher::class, 'homeroom_teacher_id');
    }

   public function students()
{
    return $this->hasMany(\App\Models\Student::class, 'class_id');
}


    public function studentAttendances()
    {
        return $this->hasMany(StudentAttendance::class, 'class_id');
    }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_class', 'class_id', 'teacher_id');
    }

}

