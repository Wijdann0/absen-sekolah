@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded-xl shadow">
    <h3 class="text-lg font-semibold mb-4">Kelas yang Anda Ampu</h3>

    <table class="min-w-full text-sm border">
        <thead class="bg-gray-50">
            <tr>
                <th class="border px-2 py-1">No</th>
                <th class="border px-2 py-1">Kelas</th>
                <th class="border px-2 py-1">Tingkat</th>
                <th class="border px-2 py-1">Jumlah Murid</th>
                <th class="border px-2 py-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
                <tr>
                    <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                    <td class="border px-2 py-1">{{ $class->name }}</td>
                    <td class="border px-2 py-1">{{ $class->grade }}</td>
                    <td class="border px-2 py-1">{{ $class->students_count }}</td>
                    <td class="border px-2 py-1 space-x-2">
                        {{-- Input absensi hari ini --}}
                        <a href="{{ route('teacher.attendance.students.create', ['class' => $class->id, 'date' => now()->toDateString()]) }}"
                           class="text-blue-600 text-xs hover:underline">
                            Input Absensi Hari Ini
                        </a>

                        {{-- Laporan absensi --}}
                        <a href="{{ route('teacher.attendance.students.report', ['class' => $class->id]) }}"
                           class="text-emerald-600 text-xs hover:underline">
                            Laporan Absensi
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="border px-2 py-4 text-center text-gray-500">
                        Belum ada kelas yang di-mapping ke Anda.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
