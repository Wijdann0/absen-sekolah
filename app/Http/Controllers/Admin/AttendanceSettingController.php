<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSetting;
use Illuminate\Http\Request;

class AttendanceSettingController extends Controller
{
    public function edit()
    {
        // selalu pakai record pertama, kalau belum ada → buat default
        $setting = AttendanceSetting::first();

        if (!$setting) {
            $setting = AttendanceSetting::create([
                'student_start_time' => '06:00:00',
                'student_end_time'   => '08:00:00',
            ]);
        }

        return view('admin.settings.attendance', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'student_start_time' => 'required|date_format:H:i',
            'student_end_time'   => 'required|date_format:H:i|after:student_start_time',
        ]);

        $setting = AttendanceSetting::firstOrFail();

        $setting->update([
            'student_start_time' => $data['student_start_time'] . ':00',
            'student_end_time'   => $data['student_end_time'] . ':00',
        ]);

        return redirect()
            ->route('admin.settings.attendance.edit')
            ->with('success', 'Pengaturan jam absensi murid berhasil disimpan.');
    }
}
