<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 'date', 'status', 'check_in_time', 'check_out_time', 'note',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
