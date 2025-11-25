@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow space-y-4">
    <h3 class="text-lg font-semibold mb-2">Tambah Kelas</h3>

    <form action="{{ route('admin.classes.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-700 mb-1">Nama Kelas</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2 text-sm @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Tingkat</label>
            <select name="grade"
                    class="w-full border rounded px-3 py-2 text-sm @error('grade') border-red-500 @enderror">
                <option value="">Pilih Tingkat</option>
                @foreach(['X','XI','XII'] as $grade)
                    <option value="{{ $grade }}" @selected(old('grade') == $grade)>{{ $grade }}</option>
                @endforeach
            </select>
            @error('grade')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Wali Kelas (opsional)</label>
            <select name="homeroom_teacher_id" class="w-full border rounded px-3 py-2 text-sm">
                <option value="">Tidak ada</option>
                @foreach($teachers as $t)
                    <option value="{{ $t->id }}" @selected(old('homeroom_teacher_id') == $t->id)>
                        {{ $t->name }} ({{ $t->subject ?? 'Umum' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div x-data="{ open: false }" class="border rounded-lg p-3">
            <div class="flex items-center justify-between cursor-pointer" @click="open = !open">
                <span class="text-sm font-semibold">Guru Pengampu Kelas</span>
                <span class="text-xs text-blue-600" x-text="open ? 'Sembunyikan' : 'Pilih Guru'"></span>
            </div>
            <div x-show="open" x-collapse class="mt-3 space-y-2">
                @foreach($teachers as $t)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="teacher_ids[]"
                               value="{{ $t->id }}"
                               @checked(collect(old('teacher_ids', []))->contains($t->id))
                               class="rounded border-gray-300">
                        <span>{{ $t->name }} <span class="text-xs text-gray-500">({{ $t->subject ?? 'Umum' }})</span></span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="text-right">
            <a href="{{ route('admin.classes.index') }}" class="text-sm text-gray-500 mr-3">Batal</a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
