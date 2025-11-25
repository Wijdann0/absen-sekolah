<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        // Kalau user belum punya data murid, jangan 500, tapi redirect sopan
        if (!$student) {
            return redirect()->route('redirect.after.login')
                ->with('error', 'Akun ini belum terhubung dengan data murid. Silakan hubungi admin.');
        }

        $today = now()->toDateString();

        $todayAttendance = StudentAttendance::where('student_id', $student->id)
            ->where('date', $today)
            ->first();

        $month = now()->month;
        $year  = now()->year;

        $monthly = StudentAttendance::where('student_id', $student->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $totalDays   = $monthly->count();
        $presentDays = $monthly->where('status', 'hadir')->count();

        $presentPercentage = $totalDays > 0
            ? round(($presentDays / $totalDays) * 100, 1)
            : 0;

        return view('student.dashboard', compact(
            'student',
            'todayAttendance',
            'presentPercentage'
        ));
    }

    public function history(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('redirect.after_login')
                ->with('error', 'Akun ini belum terhubung dengan data murid.');
        }

        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year', now()->year);

        $attendances = StudentAttendance::where('student_id', $student->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get();

        return view('student.attendance-history', compact(
            'student',
            'attendances',
            'month',
            'year'
        ));
    }

    public function checkIn()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student || !$student->class_id) {
            return back()->with('error', 'Data murid atau kelas belum lengkap. Hubungi admin.');
        }

        $today = now()->toDateString();

StudentAttendance::updateOrCreate(
    [
        'student_id' => $student->id,
        'class_id'   => $student->class_id,
        'date'       => $today,
    ],
    [
        'teacher_id' => null,      // boleh null kalau kolom sudah nullable
        'status'     => 'hadir',
    ]
);


        return back()->with('success', 'Absen hari ini berhasil direkam.');
    }
}
