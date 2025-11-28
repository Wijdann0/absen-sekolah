<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AttendanceSettingController;


use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;

use App\Http\Controllers\Student\DashboardController as StudentDashboard;

// Halaman utama -> ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route dari Breeze (login, register, dll)
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Route /dashboard (WAJIB ADA)
| Breeze redirect ke sini setelah login
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login');
    }

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->isTeacher()) {
        return redirect()->route('teacher.dashboard');
    }

    return redirect()->route('student.dashboard');
})->middleware('auth')->name('dashboard');

// (Opsional) route custom yang kamu buat sebelumnya, boleh dihapus kalau nggak dipakai
Route::get('/redirect-after-login', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    if ($user->isTeacher()) {
        return redirect()->route('teacher.dashboard');
    }
    return redirect()->route('student.dashboard');
})->middleware('auth')->name('redirect.after.login');

// ======================== ADMIN ========================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::resource('teachers', TeacherController::class);
        Route::resource('students', StudentController::class);
        Route::resource('classes', ClassController::class);

        Route::get('reports/students', [ReportController::class, 'student'])->name('reports.students');
        Route::get('reports/teachers', [ReportController::class, 'teacher'])->name('reports.teachers');
        Route::get('reports/students/export', [ReportController::class, 'exportStudents'])->name('reports.students.export');
        Route::get('reports/teachers/export', [ReportController::class, 'exportTeachers'])->name('reports.teachers.export');

        Route::get('settings/attendance', [AttendanceSettingController::class, 'edit'])
            ->name('settings.attendance.edit');

        Route::post('settings/attendance', [AttendanceSettingController::class, 'update'])
            ->name('settings.attendance.update');
    });

// ======================== TEACHER ========================
Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

        Route::get('/dashboard', [TeacherDashboard::class, 'index'])->name('dashboard');

        Route::get('/attendance/students', [TeacherAttendanceController::class, 'index'])->name('attendance.students.index');
        Route::get('/attendance/students/{class}/create', [TeacherAttendanceController::class, 'create'])->name('attendance.students.create');
        Route::post('/attendance/students/{class}', [TeacherAttendanceController::class, 'store'])->name('attendance.students.store');

        Route::get('/attendance/students/{class}/report', [TeacherAttendanceController::class, 'report'])
        ->name('attendance.students.report');

        Route::get('/attendance/me', [TeacherAttendanceController::class, 'myAttendance'])->name('attendance.me');
        Route::post('/attendance/me/check-in', [TeacherAttendanceController::class, 'checkIn'])->name('attendance.me.checkin');
        Route::post('/attendance/me/check-out', [TeacherAttendanceController::class, 'checkOut'])->name('attendance.me.checkout');
    });

// ======================== STUDENT ========================
Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');
        Route::get('/attendance/history', [StudentDashboard::class, 'history'])->name('attendance.history');
        Route::post('/attendance/check-in', [StudentDashboard::class, 'checkIn'])->name('attendance.checkin');
    });
