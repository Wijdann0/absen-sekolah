<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'nis', 'class_id', 'address', 'parent_phone', 'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
{
    return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
}


    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }
}

