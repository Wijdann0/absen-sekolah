@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-xs text-gray-400">Guru</p>
        <p class="text-2xl font-bold">{{ $teachersCount }}</p>
    </div>
    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-xs text-gray-400">Murid</p>
        <p class="text-2xl font-bold">{{ $studentsCount }}</p>
    </div>
    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-xs text-gray-400">Kelas</p>
        <p class="text-2xl font-bold">{{ $classesCount }}</p>
    </div>
    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-xs text-gray-400">Kehadiran Murid Hari Ini</p>
        <p class="text-2xl font-bold">{{ $presentPercentage }}%</p>
    </div>
</div>
@endsection
