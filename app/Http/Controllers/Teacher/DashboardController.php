<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\StudentAttendance;
use App\Models\TeacherAttendance;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
public function index()
{
    $user = Auth::user();
    $teacher = $user->teacher;

    // Kalau data guru belum ada, jangan langsung error
    if (!$teacher) {
        // bisa redirect ke halaman admin atau kasih pesan error yang ramah
        abort(500, 'Data guru untuk user ini belum ditemukan. Pastikan user ini sudah punya data di tabel teachers.');
    }

    $today   = now()->toDateString();

    $classes = $teacher->teachingClasses()->withCount('students')->get();
    $classIds = $classes->pluck('id');

    $todayStudentAttendances = StudentAttendance::whereIn('class_id', $classIds)
        ->where('date', $today)
        ->get();

    $totalStudents = $classes->sum('students_count');
    $presentStudents = $todayStudentAttendances
        ->where('status', 'hadir')
        ->pluck('student_id')
        ->unique()
        ->count();

    $presentPercentage = $totalStudents > 0
        ? round(($presentStudents / $totalStudents) * 100, 1)
        : 0;

    $todayAttendance = TeacherAttendance::where('teacher_id', $teacher->id)
        ->where('date', $today)
        ->first();

    return view('teacher.dashboard', compact(
        'classes',
        'presentPercentage',
        'todayAttendance'
    ));
}

}
