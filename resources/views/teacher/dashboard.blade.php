@extends('layouts.app')

@section('content')
<div class="space-y-4">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-500">Kelas yang Anda ampu</p>
            <p class="text-2xl font-semibold mt-1">{{ $classes->count() }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-500">Kehadiran murid di kelas Anda (hari ini)</p>
            <p class="text-2xl font-semibold mt-1">{{ $presentPercentage }}%</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-500">Status absensi Anda hari ini</p>
            <p class="text-xl font-semibold mt-1">
                @if($todayAttendance)
                    {{ strtoupper($todayAttendance->status) }}
                @else
                    Belum absen
                @endif
            </p>
        </div>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-semibold">Kelas yang Anda ampu</h3>
            <a href="{{ route('teacher.attendance.students.index') }}" class="text-xs text-blue-600 hover:underline">
                Kelola absensi murid
            </a>
        </div>

        <table class="min-w-full text-sm border">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border px-2 py-1">No</th>
                    <th class="border px-2 py-1">Kelas</th>
                    <th class="border px-2 py-1">Tingkat</th>
                    <th class="border px-2 py-1">Jumlah Murid</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                    <tr>
                        <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                        <td class="border px-2 py-1">{{ $class->name }}</td>
                        <td class="border px-2 py-1">{{ $class->grade }}</td>
                        <td class="border px-2 py-1">{{ $class->students_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border px-2 py-3 text-center text-gray-500">
                            Belum ada kelas yang di-mapping ke Anda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
