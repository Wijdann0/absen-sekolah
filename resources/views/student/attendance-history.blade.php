@extends('layouts.app')

@section('content')
<div class="space-y-4">

    <div class="bg-white p-4 rounded-xl shadow">
        <form method="GET" class="flex flex-wrap items-end gap-4 text-sm">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Bulan</label>
                <select name="month" class="border rounded px-2 py-1">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" @selected($month == $m)>
                            {{ \Carbon\Carbon::create()->month($m)->locale('id')->monthName }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Tahun</label>
                <input type="number" name="year" value="{{ $year }}"
                       class="border rounded px-2 py-1 w-24">
            </div>
            <div>
                <button class="px-4 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
        <h3 class="text-sm font-semibold mb-3">
            Riwayat Absensi: {{ \Carbon\Carbon::create($year, $month)->locale('id')->monthName }} {{ $year }}
        </h3>

        <table class="min-w-full text-sm border">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border px-2 py-1">Tanggal</th>
                    <th class="border px-2 py-1">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                    <tr>
                        <td class="border px-2 py-1">{{ \Carbon\Carbon::parse($att->date)->format('d-m-Y') }}</td>
                        <td class="border px-2 py-1 capitalize">{{ $att->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="border px-2 py-3 text-center text-gray-500">
                            Tidak ada data absensi untuk bulan ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
