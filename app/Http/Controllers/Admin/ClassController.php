<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with('homeroomTeacher')->paginate(20);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = Teacher::where('is_active', true)->get();
        return view('admin.classes.create', compact('teachers'));
    }


public function store(Request $request)
{
    $data = $request->validate([
        'name'                => 'required|string|max:255',
        'grade'               => 'required|string|max:10',
        'homeroom_teacher_id' => 'nullable|exists:teachers,id',
        'teacher_ids'         => 'nullable|array',
        'teacher_ids.*'       => 'exists:teachers,id',
    ]);

    $class = SchoolClass::create([
        'name'                => $data['name'],
        'grade'               => $data['grade'],
        'homeroom_teacher_id' => $data['homeroom_teacher_id'] ?? null,
    ]);

    if (!empty($data['teacher_ids'])) {
        $class->teachers()->sync($data['teacher_ids']);
    }

    return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil ditambahkan.');
}


public function edit(SchoolClass $class)
{
    $teachers = Teacher::where('is_active', true)->get();
    $class->load('teachers');

    return view('admin.classes.edit', compact('class', 'teachers'));
}


public function update(Request $request, SchoolClass $class)
{
    $data = $request->validate([
        'name'                => 'required|string|max:255',
        'grade'               => 'required|string|max:10',
        'homeroom_teacher_id' => 'nullable|exists:teachers,id',
        'teacher_ids'         => 'nullable|array',
        'teacher_ids.*'       => 'exists:teachers,id',
    ]);

    $class->update([
        'name'                => $data['name'],
        'grade'               => $data['grade'],
        'homeroom_teacher_id' => $data['homeroom_teacher_id'] ?? null,
    ]);

    $class->teachers()->sync($data['teacher_ids'] ?? []);

    return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diperbarui.');
}


    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
