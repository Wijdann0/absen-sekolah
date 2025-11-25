@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Dashboard Guru</h2>
            <p class="text-sm text-slate-500">Ringkasan kelas dan absensi hari ini</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('teacher.attendance.students.index') }}"
               class="px-3 py-2 rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-xs font-medium">
                Kelola Absensi Murid
            </a>
            <a href="{{ route('teacher.attendance.me') }}"
               class="px-3 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium">
                Absensi Saya
            </a>
        </div>
    </div>

    {{-- Kartu ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-sky-500 to-cyan-400 text-white rounded-2xl p-4 shadow">
            <p class="text-xs uppercase tracking-wide text-white/80">Kelas yang Anda ampu</p>
            <p class="mt-2 text-3xl font-bold">{{ $classes->count() }}</p>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-lime-400 text-white rounded-2xl p-4 shadow">
            <p class="text-xs uppercase tracking-wide text-white/80">Kehadiran murid (hari ini)</p>
            <p class="mt-2 text-3xl font-bold">{{ $presentPercentage }}%</p>
        </div>

        <div class="bg-gradient-to-br from-indigo-500 to-violet-500 text-white rounded-2xl p-4 shadow">
            <p class="text-xs uppercase tracking-wide text-white/80">Status absensi Anda</p>
            <p class="mt-2 text-xl font-semibold">
                @if($todayAttendance)
                    {{ strtoupper($todayAttendance->status) }}
                @else
                    Belum absen
                @endif
            </p>
            <p class="text-[11px] mt-1">
                Masuk: {{ $todayAttendance->check_in_time ?? '-' }} —
                Pulang: {{ $todayAttendance->check_out_time ?? '-' }}
            </p>
        </div>
    </div>

    {{-- Aksi cepat absensi guru --}}
    <div class="bg-white rounded-2xl shadow p-4 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-slate-800">Absensi Guru Hari Ini</p>
            <p class="text-xs text-slate-500">Gunakan tombol di samping untuk absen masuk / pulang.</p>
        </div>
        <div class="flex gap-2">
            @if(!$todayAttendance || !$todayAttendance->check_in_time)
                <form action="{{ route('teacher.attendance.me.checkin') }}" method="POST"
                      onsubmit="return confirm('Absen masuk sekarang?');">
                    @csrf
                    <button
                        class="px-4 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold">
                        Absen Masuk
                    </button>
                </form>
            @endif

            @if($todayAttendance && !$todayAttendance->check_out_time)
                <form action="{{ route('teacher.attendance.me.checkout') }}" method="POST"
                      onsubmit="return confirm('Absen pulang sekarang?');">
                    @csrf
                    <button
                        class="px-4 py-2 rounded-lg bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold">
                        Absen Pulang
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Tabel kelas yang diampu --}}
    <div class="bg-white rounded-2xl shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-semibold text-slate-800">Kelas yang Anda ampu</h3>
            <span class="text-[11px] px-2 py-1 rounded-full bg-slate-100 text-slate-500">
                Total: {{ $classes->count() }} kelas
            </span>
        </div>

        <table class="min-w-full text-xs border border-slate-100 rounded-lg overflow-hidden">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="border px-2 py-1 text-left">No</th>
                    <th class="border px-2 py-1 text-left">Kelas</th>
                    <th class="border px-2 py-1 text-left">Tingkat</th>
                    <th class="border px-2 py-1 text-left">Jumlah Murid</th>
                    <th class="border px-2 py-1 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                    <tr class="hover:bg-slate-50">
                        <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                        <td class="border px-2 py-1">{{ $class->name }}</td>
                        <td class="border px-2 py-1">{{ $class->grade }}</td>
                        <td class="border px-2 py-1">{{ $class->students_count }}</td>
                        <td class="border px-2 py-1 text-center">
                            <a href="{{ route('teacher.attendance.students.create', ['class' => $class->id, 'date' => now()->toDateString()]) }}"
                               class="inline-flex items-center justify-center px-3 py-1.5 rounded-full bg-sky-500 hover:bg-sky-600 text-white text-[11px] font-medium">
                                Input Absensi Hari Ini
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-2 py-3 text-center text-slate-400">
                            Belum ada kelas yang di-mapping ke Anda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
