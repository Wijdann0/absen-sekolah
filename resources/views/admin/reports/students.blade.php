@extends('layouts.app')

@section('content')
<div class="space-y-4">

    <div class="bg-white p-4 rounded-xl shadow">
        <h3 class="text-sm font-semibold mb-3">Filter Laporan Absensi Murid</h3>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="w-full border rounded px-2 py-1">
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="w-full border rounded px-2 py-1">
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Kelas</label>
                <select name="class_id" class="w-full border rounded px-2 py-1">
                    <option value="">Semua</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>
                            {{ $class->name }} ({{ $class->grade }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-500 mb-1">Murid</label>
                <select name="student_id" class="w-full border rounded px-2 py-1">
                    <option value="">Semua</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" @selected(request('student_id') == $s->id)>
                            {{ $s->name }} ({{ $s->nis }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-4 flex justify-between items-end">
                <button class="px-4 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                    Tampilkan
                </button>

                <a href="{{ route('admin.reports.students.export', request()->query()) }}"
                   class="px-4 py-2 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                    Export CSV
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
        <h3 class="text-sm font-semibold mb-3">Hasil Laporan</h3>

        <table class="min-w-full text-xs border">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border px-2 py-1">Tanggal</th>
                    <th class="border px-2 py-1">Kelas</th>
                    <th class="border px-2 py-1">NIS</th>
                    <th class="border px-2 py-1">Nama Murid</th>
                    <th class="border px-2 py-1">Status</th>
                    <th class="border px-2 py-1">Guru Pengisi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $row)
                    <tr>
                        <td class="border px-2 py-1">{{ $row->date }}</td>
                        <td class="border px-2 py-1">{{ $row->class->name ?? '-' }}</td>
                        <td class="border px-2 py-1">{{ $row->student->nis ?? '-' }}</td>
                        <td class="border px-2 py-1">{{ $row->student->name ?? '-' }}</td>
                        <td class="border px-2 py-1 capitalize">{{ $row->status }}</td>
                        <td class="border px-2 py-1">{{ $row->teacher->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border px-2 py-3 text-center text-gray-500">
                            Tidak ada data untuk filter ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $attendances->withQueryString()->links() }}
        </div>
    </div>

</div>
@endsection
