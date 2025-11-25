@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow space-y-4 max-w-xl">
    <h3 class="text-lg font-semibold mb-2">Tambah Murid</h3>

    <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-700 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('name') border-red-500 @enderror">
            @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">NIS</label>
            <input type="text" name="nis" value="{{ old('nis') }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('nis') border-red-500 @enderror">
            @error('nis') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('email') border-red-500 @enderror">
            @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Kelas</label>
            <select name="class_id" class="w-full border rounded px-3 py-2 text-sm">
                <option value="">Pilih Kelas</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected(old('class_id') == $class->id)>
                        {{ $class->name }} ({{ $class->grade }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Alamat</label>
            <textarea name="address" rows="2"
                      class="w-full border rounded px-3 py-2 text-sm">{{ old('address') }}</textarea>
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">No. HP Orang Tua</label>
            <input type="text" name="parent_phone" value="{{ old('parent_phone') }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <p class="text-xs text-gray-500">
            Password default murid baru: <code>password123</code>.
        </p>

        <div class="text-right">
            <a href="{{ route('admin.students.index') }}" class="text-sm text-gray-500 mr-3">Batal</a>
            <button class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
