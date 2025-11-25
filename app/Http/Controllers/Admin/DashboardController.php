<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\StudentAttendance;

class DashboardController extends Controller
{
    public function index()
    {
        $teachersCount = Teacher::count();
        $studentsCount = Student::count();
        $classesCount  = SchoolClass::count();

        $today = now()->toDateString();

        $totalStudentsToday = Student::count();
        $presentStudentsToday = StudentAttendance::where('date', $today)
            ->where('status', 'hadir')
            ->distinct('student_id')
            ->count('student_id');

        $presentPercentage = $totalStudentsToday > 0
            ? round(($presentStudentsToday / $totalStudentsToday) * 100, 1)
            : 0;

        return view('admin.dashboard', compact(
            'teachersCount',
            'studentsCount',
            'classesCount',
            'presentPercentage'
        ));
    }
}
