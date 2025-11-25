@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow space-y-4 max-w-xl">
    <h3 class="text-lg font-semibold mb-2">Tambah Guru</h3>

    <form action="{{ route('admin.teachers.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-700 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('name') border-red-500 @enderror">
            @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-700 mb-1">NIP (opsional)</label>
                <input type="text" name="nip" value="{{ old('nip') }}"
                       class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">Mata Pelajaran</label>
                <input type="text" name="subject" value="{{ old('subject') }}"
                       class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('email') border-red-500 @enderror">
            @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">No. HP</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <p class="text-xs text-gray-500">
            <strong>Catatan:</strong> Password default untuk guru baru adalah <code>password123</code> (bisa diubah kemudian).
        </p>

        <div class="text-right">
            <a href="{{ route('admin.teachers.index') }}" class="text-sm text-gray-500 mr-3">Batal</a>
            <button class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
