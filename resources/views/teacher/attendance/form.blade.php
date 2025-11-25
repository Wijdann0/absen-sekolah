@extends('layouts.app')

@section('content')
<div class="space-y-4">

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">
                Absensi Murid - {{ $class->name }} ({{ $class->grade }})
            </h2>
            <p class="text-sm text-slate-500">
                Tanggal: {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
            </p>
        </div>

        <form method="GET"
              action="{{ route('teacher.attendance.students.create', $class->id) }}"
              class="flex items-center gap-2 text-sm">
            <label class="text-slate-600">Tanggal:</label>
            <input type="date" name="date" value="{{ $date }}"
                   class="border rounded px-2 py-1 text-sm">
            <button class="px-3 py-1.5 rounded bg-sky-500 hover:bg-sky-600 text-white text-xs font-medium">
                Ganti
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow p-4">
        <form action="{{ route('teacher.attendance.students.store', $class->id) }}"
              method="POST">
            @csrf

            <input type="hidden" name="date" value="{{ $date }}">

            <table class="min-w-full text-xs border border-slate-100 rounded-lg overflow-hidden">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="border px-2 py-1 text-left">No</th>
                        <th class="border px-2 py-1 text-left">NIS</th>
                        <th class="border px-2 py-1 text-left">Nama Murid</th>
                        <th class="border px-2 py-1 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($class->students as $student)
                       @php
    $current = $attendances[$student->id] ?? null;
    $currentStatus = $current->status ?? 'hadir';
@endphp

                        <tr class="hover:bg-slate-50">
                            <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                            <td class="border px-2 py-1">{{ $student->nis }}</td>
                            <td class="border px-2 py-1">{{ $student->name }}</td>
                            <td class="border px-2 py-1 text-center">
                                <select name="attendance[{{ $student->id }}]"
                                        class="border rounded px-2 py-1 text-xs">
                                    <option value="hadir" @selected($currentStatus === 'hadir')>Hadir</option>
                                    <option value="izin" @selected($currentStatus === 'izin')>Izin</option>
                                    <option value="sakit" @selected($currentStatus === 'sakit')>Sakit</option>
                                    <option value="alfa"  @selected($currentStatus === 'alfa')>Alfa</option>
                                </select>
                            </td>
                        </tr>
                 @empty
    <tr>
        <td colspan="4" class="border px-2 py-4 text-center">
            <div class="inline-flex items-center px-3 py-2 rounded-full bg-amber-50 border border-amber-200 text-xs text-amber-700">
                Kelas ini belum memiliki murid. Tambahkan murid dari menu <strong>Admin &gt; Data Murid</strong>
                dan pastikan memilih kelas ini.
            </div>
        </td>
    </tr>
@endempty

                </tbody>
            </table>

            <div class="mt-4 flex justify-between items-center">
                <p class="text-xs text-slate-500">
                    *Pastikan semua status sudah diisi dengan benar sebelum menyimpan.
                </p>
                <button class="px-5 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold">
                    Simpan Absensi
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
