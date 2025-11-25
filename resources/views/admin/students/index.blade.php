@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded-xl shadow">

    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold">Data Murid</h3>
        <a href="{{ route('admin.students.create') }}"
           class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
            + Tambah Murid
        </a>
    </div>

    <table class="min-w-full text-sm border">
        <thead class="bg-gray-50">
            <tr>
                <th class="border px-2 py-1">No</th>
                <th class="border px-2 py-1">NIS</th>
                <th class="border px-2 py-1">Nama</th>
                <th class="border px-2 py-1">Kelas</th>
                <th class="border px-2 py-1">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($students as $student)
                <tr>
                    <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                    <td class="border px-2 py-1">{{ $student->nis }}</td>
                    <td class="border px-2 py-1">{{ $student->name }}</td>
                    <td class="border px-2 py-1">{{ $student->class->name ?? '-' }}</td>
                    <td class="border px-2 py-1">
                        <a href="{{ route('admin.students.edit', $student->id) }}" class="text-blue-600 text-xs">Edit</a>
                        <form action="{{ route('admin.students.destroy', $student->id) }}"
                              method="POST" class="inline-block ml-2"
                              onsubmit="return confirm('Yakin hapus?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-xs">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $students->links() }}</div>

</div>
@endsection
