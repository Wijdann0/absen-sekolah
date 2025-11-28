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

         @php
    // $beforeStart, $afterEnd, $absenDibuka, $startTime, $endTime, $secondsToOpen, $secondsToClose
    $startLabel = substr($startTime, 0, 5);
    $endLabel   = substr($endTime, 0, 5);
@endphp

<div class="mt-6">
    @if(!$todayAttendance || $todayAttendance->status !== 'hadir')

        @if($absenDibuka)
            {{-- ABSEN SEDANG DIBUKA --}}
            <form action="{{ route('student.attendance.checkin') }}" method="POST"
                  onsubmit="return confirm('Absen sekarang?');">
                @csrf
                <button
                    class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 rounded-xl text-sm font-semibold shadow-lg text-white">
                    Absen Hadir Sekarang
                </button>
            </form>

            @if($secondsToClose !== null)
                <p class="mt-3 text-xs text-white/80" id="countdown-text">
                    Absensi akan ditutup dalam <span class="font-semibold" id="countdown-timer"></span>
                </p>
            @endif

        @elseif($beforeStart)
            {{-- BELUM DIBUKA --}}
            <div class="inline-block px-4 py-2 rounded-xl bg-blue-50 border border-blue-200 text-xs text-blue-800 shadow-sm">
                Absensi <strong>belum dibuka</strong>.<br>
                Dibuka pukul <strong>{{ $startLabel }}</strong>.
                @if($secondsToOpen !== null)
                    <div class="mt-1">
                        Dibuka dalam <span id="countdown-timer" class="font-semibold"></span>
                    </div>
                @endif
            </div>

        @elseif($afterEnd)
            {{-- SUDAH DITUTUP --}}
            <div class="inline-block px-4 py-2 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 shadow-sm">
                Absensi <strong>sudah ditutup</strong>.<br>
                Ditutup pukul <strong>{{ $endLabel }}</strong>.
            </div>
        @endif

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
@section('scripts')
<script>
    (function () {
        // ambil data dari blade
        let secondsToOpen  = @json($secondsToOpen);
        let secondsToClose = @json($secondsToClose);

        let totalSeconds = secondsToOpen ?? secondsToClose;
        if (totalSeconds === null) return;

        const timerEl = document.getElementById('countdown-timer');
        if (!timerEl) return;

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

