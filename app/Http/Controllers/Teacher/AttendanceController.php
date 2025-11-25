<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\StudentAttendance;
use App\Models\TeacherAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
public function index()
{
    $teacher = Auth::user()->teacher;

    // hanya kelas yang dia ampu (mapping teacher_class)
    $classes = $teacher->teachingClasses()->withCount('students')->get();

    return view('teacher.attendance.index', compact('classes'));
}
public function create(SchoolClass $class, Request $request)
{
    $teacher = auth()->user()->teacher;

    if (!$teacher->teachingClasses->contains('id', $class->id)) {
        abort(403);
    }

    $date = $request->query('date', now()->toDateString());

    $class->load('students');

    // ⬅️ Semua absensi (baik yang dibuat siswa maupun guru)
    $attendances = StudentAttendance::where('class_id', $class->id)
        ->where('date', $date)
        ->get()
        ->keyBy('student_id');

    return view('teacher.attendance.form', [
        'class'       => $class,
        'date'        => $date,
        'attendances' => $attendances
    ]);
}


public function store(SchoolClass $class, Request $request)
{
    $teacher = auth()->user()->teacher;

    if (!$teacher->teachingClasses->contains('id', $class->id)) {
        abort(403);
    }

    $data = $request->validate([
        'date' => 'required|date',
        'attendance' => 'required|array',
        'attendance.*' => 'required|in:hadir,izin,sakit,alfa',
    ]);

    foreach ($data['attendance'] as $studentId => $status) {

        $existing = StudentAttendance::where('student_id', $studentId)
            ->where('class_id', $class->id)
            ->where('date', $data['date'])
            ->first();

        // Jika siswa sudah absen mandiri dan status sama → jangan overwrite
        if ($existing && $existing->teacher_id === null && $existing->status === $status) {
            continue;
        }

        StudentAttendance::updateOrCreate(
            [
                'student_id' => $studentId,
                'class_id'   => $class->id,
                'date'       => $data['date'],
            ],
            [
                'teacher_id' => $teacher->id,
                'status'     => $status,
            ]
        );
    }

    return redirect()
        ->route('teacher.attendance.students.create', ['class' => $class->id, 'date' => $data['date']])
        ->with('success', 'Absensi berhasil disimpan.');
}



    public function myAttendance()
    {
        $teacher = Auth::user()->teacher;
        $today = now()->toDateString();

        $todayAttendance = TeacherAttendance::where('teacher_id', $teacher->id)
            ->where('date', $today)
            ->first();

        return view('teacher.attendance.me', compact('todayAttendance'));
    }

    public function checkIn()
    {
        $teacher = Auth::user()->teacher;
        $today = now()->toDateString();

        TeacherAttendance::updateOrCreate(
            ['teacher_id' => $teacher->id, 'date' => $today],
            ['status' => 'hadir', 'check_in_time' => now()->format('H:i:s')]
        );

        return back()->with('success', 'Absen masuk berhasil.');
    }

    public function checkOut()
    {
        $teacher = Auth::user()->teacher;
        $today = now()->toDateString();

        TeacherAttendance::where('teacher_id', $teacher->id)
            ->where('date', $today)
            ->update(['check_out_time' => now()->format('H:i:s')]);

        return back()->with('success', 'Absen pulang berhasil.');
    }
}
