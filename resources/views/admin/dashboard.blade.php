@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Dashboard Admin</h2>
            <p class="text-sm text-slate-600">Ringkasan data guru, murid, kelas, dan absensi hari ini</p>
        </div>
    </div>

    {{-- Kartu ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        {{-- Guru --}}
        <div class="bg-gradient-to-br from-indigo-500 to-blue-500 text-white rounded-2xl p-4 shadow">
            <p class="text-xs uppercase tracking-wide text-white/80">Guru</p>
            <p class="mt-2 text-3xl font-extrabold">
                {{ $totalTeachers ?? 0 }}
            </p>
            <p class="mt-1 text-[11px] text-white/80">Total guru terdaftar</p>
        </div>

        {{-- Murid --}}
        <div class="bg-gradient-to-br from-sky-500 to-cyan-400 text-white rounded-2xl p-4 shadow">
            <p class="text-xs uppercase tracking-wide text-white/80">Murid</p>
            <p class="mt-2 text-3xl font-extrabold">
                {{ $totalStudents ?? 0 }}
            </p>
            <p class="mt-1 text-[11px] text-white/80">Total murid aktif</p>
        </div>

        {{-- Kelas --}}
        <div class="bg-gradient-to-br from-emerald-500 to-lime-400 text-white rounded-2xl p-4 shadow">
            <p class="text-xs uppercase tracking-wide text-white/80">Kelas</p>
            <p class="mt-2 text-3xl font-extrabold">
                {{ $totalClasses ?? 0 }}
            </p>
            <p class="mt-1 text-[11px] text-white/80">Rombel yang aktif</p>
        </div>

        {{-- Kehadiran murid hari ini --}}
        <div class="bg-gradient-to-br from-violet-500 to-fuchsia-500 text-white rounded-2xl p-4 shadow">
            <p class="text-xs uppercase tracking-wide text-white/80">Kehadiran Murid Hari Ini</p>
            <p class="mt-2 text-3xl font-extrabold">
                {{ $todayStudentPresentPercentage ?? 0 }}%
            </p>
            <p class="mt-1 text-[11px] text-white/80">
                Persentase murid dengan status hadir
            </p>
        </div>
    </div>

    {{-- Opsional: tabel absensi terbaru --}}
    @if(!empty($latestStudentAttendances) && count($latestStudentAttendances))
        <div class="bg-white rounded-2xl p-4 shadow border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-slate-800">Absensi Murid Terbaru</h3>
                <a href="{{ route('admin.reports.students') }}"
                   class="text-xs text-blue-600 hover:underline">
                    Lihat laporan lengkap →
                </a>
            </div>

            <table class="min-w-full text-xs border border-slate-100 rounded-lg overflow-hidden">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="border px-2 py-1 text-left">Tanggal</th>
                        <th class="border px-2 py-1 text-left">Murid</th>
                        <th class="border px-2 py-1 text-left">Kelas</th>
                        <th class="border px-2 py-1 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestStudentAttendances as $row)
                        <tr class="hover:bg-slate-50">
                            <td class="border px-2 py-1">{{ $row->date }}</td>
                            <td class="border px-2 py-1">{{ $row->student->name ?? '-' }}</td>
                            <td class="border px-2 py-1">{{ $row->class->name ?? '-' }}</td>
                            <td class="border px-2 py-1 capitalize">{{ $row->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
