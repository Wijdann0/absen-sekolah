<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\Teacher;
use App\Models\TeacherAttendance;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Laporan absensi murid
     */
    public function student(Request $request)
    {
        $classes  = SchoolClass::orderBy('grade')->orderBy('name')->get();
        $students = Student::with('class')->orderBy('name')->get();

        $query = StudentAttendance::with(['student.class', 'teacher', 'class'])
            ->orderBy('date', 'desc');

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $attendances = $query->paginate(50);

        return view('admin.reports.students', compact(
            'attendances',
            'classes',
            'students'
        ));
    }

    /**
     * Laporan absensi guru
     */
    public function teacher(Request $request)
    {
        $teachers = Teacher::orderBy('name')->get();

        $query = TeacherAttendance::with('teacher')
            ->orderBy('date', 'desc');

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $attendances = $query->paginate(50);

        return view('admin.reports.teachers', compact(
            'attendances',
            'teachers'
        ));
    }

    /**
     * Export CSV laporan murid
     */
    public function exportStudents(Request $request): StreamedResponse
    {
        $fileName = 'laporan_absensi_murid_' . now()->format('Ymd_His') . '.csv';

        $callback = function () use ($request) {
            $handle = fopen('php://output', 'w');

            // Header CSV
            fputcsv($handle, [
                'Tanggal',
                'Kelas',
                'NIS',
                'Nama Murid',
                'Status',
                'Guru Pengisi',
            ]);

            $query = StudentAttendance::with(['student.class', 'teacher', 'class'])
                ->orderBy('date', 'desc');

            if ($request->filled('date_from')) {
                $query->whereDate('date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('date', '<=', $request->date_to);
            }

            if ($request->filled('class_id')) {
                $query->where('class_id', $request->class_id);
            }

            if ($request->filled('student_id')) {
                $query->where('student_id', $request->student_id);
            }

            $query->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->date,
                        $row->class->name ?? '-',
                        $row->student->nis ?? '-',
                        $row->student->name ?? '-',
                        $row->status,
                        $row->teacher->name ?? '-',
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->streamDownload($callback, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Export CSV laporan guru
     */
    public function exportTeachers(Request $request): StreamedResponse
    {
        $fileName = 'laporan_absensi_guru_' . now()->format('Ymd_His') . '.csv';

        $callback = function () use ($request) {
            $handle = fopen('php://output', 'w');

            // Header CSV
            fputcsv($handle, [
                'Tanggal',
                'Nama Guru',
                'Status',
                'Jam Masuk',
                'Jam Pulang',
            ]);

            $query = TeacherAttendance::with('teacher')
                ->orderBy('date', 'desc');

            if ($request->filled('date_from')) {
                $query->whereDate('date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('date', '<=', $request->date_to);
            }

            if ($request->filled('teacher_id')) {
                $query->where('teacher_id', $request->teacher_id);
            }

            $query->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->date,
                        $row->teacher->name ?? '-',
                        $row->status,
                        $row->check_in_time,
                        $row->check_out_time,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->streamDownload($callback, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
