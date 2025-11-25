@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded-xl shadow space-y-4">
    <div>
        <p class="text-sm text-gray-500">Tanggal</p>
        <p class="text-xl font-semibold">{{ now()->translatedFormat('d F Y') }}</p>
    </div>

    <div>
        <p class="text-sm text-gray-500 mb-1">Status hari ini</p>
        @if($todayAttendance)
            <p class="text-lg font-semibold mb-1">{{ strtoupper($todayAttendance->status) }}</p>
            <p class="text-xs text-gray-500">
                Masuk: {{ $todayAttendance->check_in_time ?? '-' }} |
                Pulang: {{ $todayAttendance->check_out_time ?? '-' }}
            </p>
        @else
            <p class="text-lg font-semibold">Belum absen</p>
        @endif
    </div>

    <div class="flex gap-3">
        @if(!$todayAttendance || !$todayAttendance->check_in_time)
            <form action="{{ route('teacher.attendance.me.checkin') }}" method="POST"
                  onsubmit="return confirm('Absen masuk sekarang?');">
                @csrf
                <button class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700">
                    Absen Masuk
                </button>
            </form>
        @endif

        @if($todayAttendance && !$todayAttendance->check_out_time)
            <form action="{{ route('teacher.attendance.me.checkout') }}" method="POST"
                  onsubmit="return confirm('Absen pulang sekarang?');">
                @csrf
                <button class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                    Absen Pulang
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
