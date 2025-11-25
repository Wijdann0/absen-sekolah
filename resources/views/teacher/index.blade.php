@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded-xl shadow">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold">Data Guru</h3>
        <a href="{{ route('admin.teachers.create') }}"
           class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
            + Tambah Guru
        </a>
    </div>

    <table class="min-w-full text-sm border">
        <thead class="bg-gray-50">
            <tr>
                <th class="border px-2 py-1 text-left">No</th>
                <th class="border px-2 py-1 text-left">Nama</th>
                <th class="border px-2 py-1 text-left">NIP</th>
                <th class="border px-2 py-1 text-left">Mapel</th>
                <th class="border px-2 py-1 text-left">Email</th>
                <th class="border px-2 py-1 text-left">HP</th>
                <th class="border px-2 py-1 text-left">Status</th>
                <th class="border px-2 py-1 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teachers as $teacher)
                <tr>
                    <td class="border px-2 py-1">{{ $loop->iteration + ($teachers->currentPage()-1)*$teachers->perPage() }}</td>
                    <td class="border px-2 py-1">{{ $teacher->name }}</td>
                    <td class="border px-2 py-1">{{ $teacher->nip ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $teacher->subject ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $teacher->email }}</td>
                    <td class="border px-2 py-1">{{ $teacher->phone ?? '-' }}</td>
                    <td class="border px-2 py-1">
                        @if($teacher->is_active)
                            <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">
                                Aktif
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-700">
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="border px-2 py-1 text-center">
                        <a href="{{ route('admin.teachers.edit', $teacher->id) }}"
                           class="text-blue-600 hover:underline text-xs">Edit</a>

                        <form action="{{ route('admin.teachers.destroy', $teacher->id) }}"
                              method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Yakin ingin menghapus guru ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:underline text-xs ml-2">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="border px-2 py-4 text-center text-gray-500">
                        Belum ada data guru.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $teachers->links() }}
    </div>
</div>
@endsection
