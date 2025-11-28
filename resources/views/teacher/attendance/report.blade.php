@extends('layouts.app')

@section('content')
<div class="space-y-4">
        <a href="{{ route('teacher.attendance.students.index') }}">
        <button
        class="bg-white text-center w-32 rounded-2xl h-8 relative text-black text-xl font-semibold group"
        type="button"
        >
        <div
            class="bg-green-400 rounded-xl h-6 w-1/4 flex items-center justify-center absolute left-1 top-[4px] group-hover:w-[120px] z-10 duration-500"
        >
            <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 1024 1024"
            height="25px"
            width="25px"
            >
            <path
                d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
                fill="#000000"
            ></path>
            <path
                d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
                fill="#000000"
            ></path>
            </svg>
        </div>
        <p class="translate-x-2 text-base">Go Back</p>
        </button>
    </a>

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">
                Laporan Absensi Murid - {{ $class->name }} ({{ $class->grade }})
            </h2>
            <p class="text-xs text-slate-500">
                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }}
                s/d
                {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}
            </p>
        </div>

        <div class="space-x-2">
            <button onclick="window.print()"
                    class="px-3 py-2 bg-slate-800 text-white text-xs rounded-lg hover:bg-slate-900">
                Cetak Laporan
            </button>
            <a href="{{ route('teacher.attendance.students.index') }}"
               class="px-3 py-2 bg-slate-100 text-slate-700 text-xs rounded-lg hover:bg-slate-200">
                Kembali
            </a>
        </div>
    </div>

    {{-- Filter tanggal --}}
    <div class="bg-white rounded-xl shadow p-3">
        <form method="GET" class="flex flex-wrap items-end gap-3 text-xs">
            <div>
                <label class="block text-[11px] text-slate-500 mb-1">Dari tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                       class="border rounded px-2 py-1 text-xs">
            </div>
            <div>
                <label class="block text-[11px] text-slate-500 mb-1">Sampai tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                       class="border rounded px-2 py-1 text-xs">
            </div>
            <div>
                <button class="px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white rounded text-xs">
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel laporan --}}
    <div class="bg-white rounded-xl shadow p-4 print:p-0">
        <table class="min-w-full text-[11px] border border-slate-200 print:text-[10px]">
            <thead class="bg-slate-50">
                <tr>
                    <th class="border px-2 py-1 text-left">Tanggal</th>
                    <th class="border px-2 py-1 text-left">Nama Murid</th>
                    <th class="border px-2 py-1 text-left">NIS</th>
                    <th class="border px-2 py-1 text-left">Status</th>
                    <th class="border px-2 py-1 text-left">Waktu Tercatat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                    <tr class="hover:bg-slate-50">
                        <td class="border px-2 py-1">
                            {{ \Carbon\Carbon::parse($att->date)->format('d-m-Y') }}
                        </td>
                        <td class="border px-2 py-1">
                            {{ $att->student->name ?? '-' }}
                        </td>
                        <td class="border px-2 py-1">
                            {{ $att->student->nis ?? '-' }}
                        </td>
                        <td class="border px-2 py-1 capitalize">
                            {{ $att->status }}
                        </td>
                        <td class="border px-2 py-1">
                            {{-- pakai created_at sebagai waktu rekam --}}
                            {{ optional($att->created_at)->format('d-m-Y H:i') ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-2 py-3 text-center text-slate-400">
                            Tidak ada data absensi pada rentang tanggal ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- Sedikit CSS untuk mode print --}}
<style>
@media print {
    body {
        background: #ffffff !important;
    }
    aside, nav, header, footer, .no-print {
        display: none !important;
    }
    main {
        padding: 0 !important;
    }
}
</style>
@endsection
