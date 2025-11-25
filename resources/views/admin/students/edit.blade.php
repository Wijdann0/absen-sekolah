@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow space-y-4 max-w-xl">
    <h3 class="text-lg font-semibold mb-2">Edit Murid: {{ $student->name }}</h3>

    <form action="{{ route('admin.students.update', $student->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm text-gray-700 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $student->name) }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">NIS</label>
            <input type="text" name="nis" value="{{ old('nis', $student->nis) }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $student->user->email ?? '') }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Kelas</label>
            <select name="class_id" class="w-full border rounded px-3 py-2 text-sm">
                <option value="">Pilih Kelas</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected(old('class_id', $student->class_id) == $class->id)>
                        {{ $class->name }} ({{ $class->grade }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Alamat</label>
            <textarea name="address" rows="2"
                      class="w-full border rounded px-3 py-2 text-sm">{{ old('address', $student->address) }}</textarea>
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">No. HP Orang Tua</label>
            <input type="text" name="parent_phone" value="{{ old('parent_phone', $student->parent_phone) }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1"
                   @checked(old('is_active', $student->is_active)) class="rounded border-gray-300">
            <span class="text-sm">Aktif</span>
        </div>

        <div class="text-right">
            <a href="{{ route('admin.students.index') }}" class="text-sm text-gray-500 mr-3">Batal</a>
            <button class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
