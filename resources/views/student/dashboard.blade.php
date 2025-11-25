@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Dashboard Siswa</h2>
            <p class="text-sm text-slate-500">Halo, {{ $student->name }} 👋</p>
        </div>
        <div class="text-xs px-3 py-1 rounded-full bg-sky-100 text-sky-700">
            Kelas: {{ $student->class->name ?? '-' }} ({{ $student->class->grade ?? '-' }})
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Kartu status hari ini + tombol absen --}}
        <div class="bg-gradient-to-br from-sky-500 via-indigo-500 to-violet-500 rounded-2xl p-5 text-white shadow">
            <p class="text-xs uppercase tracking-wide text-white/80">Status kehadiran hari ini</p>
            <p class="mt-2 text-3xl font-bold">
                @if($todayAttendance)
                    {{ strtoupper($todayAttendance->status) }}
                @else
                    Belum absen
                @endif
            </p>
            <p class="mt-1 text-xs text-white/80">
                Tanggal: {{ now()->translatedFormat('d F Y') }}
            </p>

            <div class="mt-4">
                @if(!$todayAttendance || $todayAttendance->status !== 'hadir')
                    <form action="{{ route('student.attendance.checkin') }}" method="POST"
                          onsubmit="return confirm('Absen hadir untuk hari ini?');">
                        @csrf
                        <button
                            class="px-4 py-2 rounded-lg bg-emerald-400 hover:bg-emerald-500 text-xs font-semibold shadow">
                            Absen Hadir Sekarang
                        </button>
                    </form>
                @else
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-emerald-400/90 text-xs font-semibold">
                        ✅ Kamu sudah absen hadir hari ini
                    </span>
                @endif
            </div>
        </div>

        {{-- Kartu persentase kehadiran bulan ini --}}
        <div class="bg-white rounded-2xl p-5 shadow flex flex-col justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Kehadiran bulan ini</p>
                <p class="mt-2 text-3xl font-bold text-slate-800">{{ $presentPercentage }}%</p>
                <p class="mt-1 text-xs text-slate-500">
                    Semakin tinggi persentasenya, semakin baik kedisiplinanmu 💪
                </p>
            </div>

            <div class="mt-4 flex items-center justify-between">
                <div class="w-full bg-slate-100 rounded-full h-2 mr-3">
                    <div class="h-2 rounded-full bg-emerald-500"
                         style="width: {{ $presentPercentage }}%"></div>
                </div>
                <a href="{{ route('student.attendance.history') }}"
                   class="text-xs text-sky-600 hover:underline font-medium">
                    Lihat riwayat
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
