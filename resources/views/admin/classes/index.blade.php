@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded-xl shadow">

    <div class="flex justify-between mb-4">
        <h3 class="text-lg font-semibold">Data Kelas</h3>
        <a class="px-4 py-2 bg-blue-600 text-white rounded text-sm" 
           href="{{ route('admin.classes.create') }}">
            + Tambah Kelas
        </a>
    </div>

    <table class="min-w-full text-sm border">
        <thead class="bg-gray-50">
            <tr>
                <th class="border px-2 py-1">No</th>
                <th class="border px-2 py-1">Nama Kelas</th>
                <th class="border px-2 py-1">Tingkat</th>
                <th class="border px-2 py-1">Wali Kelas</th>
                <th class="border px-2 py-1">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse ($classes as $class)
            <tr>
                <td class="border px-2 py-1">{{ $loop->iteration }}</td>
                <td class="border px-2 py-1">{{ $class->name }}</td>
                <td class="border px-2 py-1">{{ $class->grade }}</td>
                <td class="border px-2 py-1">{{ $class->homeroomTeacher->name ?? '-' }}</td>
                <td class="border px-2 py-1">
                    <a class="text-blue-600 text-xs"
                       href="{{ route('admin.classes.edit', $class->id) }}">Edit</a>

                    <form action="{{ route('admin.classes.destroy', $class->id) }}"
                          method="POST"
                          class="inline-block ml-2"
                          onsubmit="return confirm('Hapus kelas?');">
                        @csrf @method('DELETE')
                        <button class="text-red-600 text-xs">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center py-4">Tidak ada data kelas.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $classes->links() }}</div>

</div>
@endsection
