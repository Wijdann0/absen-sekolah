@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow space-y-4 max-w-xl">
    <h3 class="text-lg font-semibold mb-2">Edit Guru: {{ $teacher->name }}</h3>

    <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm text-gray-700 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $teacher->name) }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-700 mb-1">NIP</label>
                <input type="text" name="nip" value="{{ old('nip', $teacher->nip) }}"
                       class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">Mata Pelajaran</label>
                <input type="text" name="subject" value="{{ old('subject', $teacher->subject) }}"
                       class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $teacher->email) }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">No. HP</label>
            <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1"
                   @checked(old('is_active', $teacher->is_active)) class="rounded border-gray-300">
            <span class="text-sm">Aktif</span>
        </div>

        <div class="text-right">
            <a href="{{ route('admin.teachers.index') }}" class="text-sm text-gray-500 mr-3">Batal</a>
            <button class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
