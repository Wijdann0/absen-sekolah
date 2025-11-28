@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div>
        <h2 class="text-2xl font-bold text-slate-800">Pengaturan Jam Absensi Murid</h2>
        <p class="text-sm text-slate-600">
            Atur jam buka dan tutup absensi harian untuk seluruh murid.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 max-w-lg">
        <form action="{{ route('admin.settings.attendance.update') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Jam Buka Absensi
                </label>
                <input type="time" name="student_start_time"
                       value="{{ old('student_start_time', \Illuminate\Support\Str::of($setting->student_start_time)->substr(0,5)) }}"
                       class="border rounded-lg px-3 py-2 text-sm w-full">
                @error('student_start_time')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Jam Tutup Absensi
                </label>
                <input type="time" name="student_end_time"
                       value="{{ old('student_end_time', \Illuminate\Support\Str::of($setting->student_end_time)->substr(0,5)) }}"
                       class="border rounded-lg px-3 py-2 text-sm w-full">
                @error('student_end_time')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button class="px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
