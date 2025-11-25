@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Dashboard Siswa</h2>
            <p class="text-sm text-slate-600">Halo, {{ $student->name }} 👋</p>
        </div>
        <div class="text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-700 shadow-sm border">
            Kelas: {{ $student->class->name ?? '-' }} ({{ $student->class->grade ?? '-' }})
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Kartu kehadiran --}}
        <div class="bg-gradient-to-br from-indigo-500 via-blue-500 to-purple-500 rounded-2xl p-6 text-white shadow-lg">
            <p class="uppercase tracking-wide text-xs text-white/80">Kehadiran Hari Ini</p>
            <p class="text-4xl font-extrabold mt-3">
                @if($todayAttendance)
                    {{ strtoupper($todayAttendance->status) }}
                @else
                    Belum absen
                @endif
            </p>

            <p class="mt-1 text-sm text-white/70">
                {{ now()->translatedFormat('d F Y') }}
            </p>

            <div class="mt-6">
                @if(!$todayAttendance || $todayAttendance->status !== 'hadir')
                    <form action="{{ route('student.attendance.checkin') }}" method="POST"
                          onsubmit="return confirm('Absen sekarang?');">
                        @csrf
                        <button
                            class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 rounded-xl text-sm font-semibold shadow-lg">
                            Absen Hadir Sekarang
                        </button>
                    </form>
                @else
                    <span class="inline-block px-4 py-1 bg-emerald-300 rounded-full text-slate-800 text-xs font-semibold shadow">
                        Kamu sudah absen hari ini
                    </span>
                @endif
            </div>
        </div>

        {{-- Persentase bulan ini --}}
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
            <p class="uppercase tracking-wide text-xs text-slate-500">Kehadiran Bulan Ini</p>
            <p class="text-4xl font-bold mt-3 text-slate-800">{{ $presentPercentage }}%</p>
            <p class="text-xs text-slate-500 mt-1">
                Semakin tinggi persentasenya, semakin baik kedisiplinanmu 💪
            </p>

            <div class="mt-5">
                <div class="w-full h-3 bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-3 bg-emerald-500"
                         style="width: {{ $presentPercentage }}%;">
                    </div>
                </div>
            </div>

            <div class="mt-4 text-right">
                <a href="{{ route('student.attendance.history') }}"
                   class="text-sm font-medium text-blue-600 hover:underline">
                    Lihat Riwayat →
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
