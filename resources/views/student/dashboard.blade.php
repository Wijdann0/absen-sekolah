@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Dashboard Siswa</h2>
            <p class="text-sm text-slate-500">Halo, {{ $student->name }} 👋</p>
        </div>
        <div class="text-xs px-3 py-1 rounded-full bg-sky-100 text-sky-700">
            Kelas: {{ $student->class->name ?? '-' }} ({{ $student->class->grade ?? '-' }})
        </div>
    </div>

    @php
        // label jam untuk ditampilkan
        $startLabel = substr($startTime, 0, 5); // 06:00
        $endLabel   = substr($endTime, 0, 5);   // 08:00
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- KARTU STATUS HARI INI + TOMBOL ABSEN / INFO WAKTU --}}
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

            <div class="mt-4 space-y-2">

                {{-- BELUM ABSEN / BUKAN HADIR --}}
                @if(!$todayAttendance || $todayAttendance->status !== 'hadir')

                    {{-- ABSEN SEDANG DIBUKA --}}
                    @if($absenDibuka)
                        <form action="{{ route('student.attendance.checkin') }}" method="POST"
                              onsubmit="return confirm('Absen hadir sekarang?');">
                            @csrf
                            <button
                                class="px-4 py-2 rounded-lg bg-emerald-400 hover:bg-emerald-500 text-xs font-semibold shadow text-white">
                                Absen Hadir Sekarang
                            </button>
                        </form>

                        @if($secondsToClose !== null)
                            <p class="text-[11px] text-white/80" id="countdown-wrapper" data-seconds="{{ $secondsToClose }}" data-mode="close">
                                Absensi akan ditutup dalam
                                <span class="font-semibold" id="countdown-timer"></span>
                            </p>
                        @endif

                    {{-- SEBELUM JAM BUKA --}}
                    @elseif($beforeStart)
                        <div class="inline-block px-4 py-2 rounded-lg bg-blue-50/90 text-blue-800 border border-blue-200 text-[11px] shadow">
                            Absensi <strong>belum dibuka</strong>.<br>
                            Dibuka pukul <strong>{{ $startLabel }}</strong>.
                            @if($secondsToOpen !== null)
                                <div class="mt-1">
                                    Dibuka dalam
                                    <span id="countdown-timer" class="font-semibold"></span>
                                </div>
                                <span id="countdown-wrapper" data-seconds="{{ $secondsToOpen }}" data-mode="open" class="hidden"></span>
                            @endif
                        </div>

                    {{-- SETELAH JAM TUTUP --}}
                    @elseif($afterEnd)
                        <div class="inline-block px-4 py-2 rounded-lg bg-rose-50/90 text-rose-800 border border-rose-200 text-[11px] shadow">
                            Absensi <strong>sudah ditutup</strong>.<br>
                            Ditutup pukul <strong>{{ $endLabel }}</strong>.
                        </div>
                    @endif

                {{-- SUDAH ABSEN HADIR --}}
                @else
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-emerald-400/90 text-xs font-semibold text-slate-900 shadow">
                        ✅ Kamu sudah absen hadir hari ini
                    </span>
                @endif

                {{-- INFO JAM BUKA/TUTUP --}}
                <p class="text-[11px] text-white/70">
                    Jam absensi: {{ $startLabel }} - {{ $endLabel }} (mengikuti waktu server).
                </p>
            </div>
        </div>

        {{-- KARTU PERSENTASE KEHADIRAN BULAN INI --}}
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

{{-- SCRIPT COUNTDOWN --}}
<script>
    (function () {
        const wrapper = document.getElementById('countdown-wrapper');
        const timerEl = document.getElementById('countdown-timer');
        if (!wrapper || !timerEl) return;

        let totalSeconds = parseInt(wrapper.dataset.seconds || '0', 10);
        if (isNaN(totalSeconds) || totalSeconds <= 0) return;

        function formatTime(sec) {
            if (sec < 0) sec = 0;
            const m = Math.floor(sec / 60);
            const s = sec % 60;
            return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        }

        timerEl.textContent = formatTime(totalSeconds);

        setInterval(() => {
            totalSeconds--;
            if (totalSeconds < 0) totalSeconds = 0;
            timerEl.textContent = formatTime(totalSeconds);
        }, 1000);
    })();
</script>
@endsection
