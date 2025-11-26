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
    $totalTeachers = Teacher::count();
    $totalStudents = Student::count();
    $totalClasses  = SchoolClass::count();

    $today = now()->toDateString();

    $todayAttendances = StudentAttendance::where('date', $today)->get();

    $totalStudentsToday = $totalStudents; // atau bisa dihitung hanya siswa aktif
    $presentStudents    = $todayAttendances->where('status', 'hadir')
        ->pluck('student_id')->unique()->count();

    $todayStudentPresentPercentage = $totalStudentsToday > 0
        ? round(($presentStudents / $totalStudentsToday) * 100, 1)
        : 0;

    $latestStudentAttendances = StudentAttendance::with(['student', 'class'])
        ->orderBy('date', 'desc')
        ->limit(10)
        ->get();

    return view('admin.dashboard', compact(
        'totalTeachers',
        'totalStudents',
        'totalClasses',
        'todayStudentPresentPercentage',
        'latestStudentAttendances'
    ));
    }
}
