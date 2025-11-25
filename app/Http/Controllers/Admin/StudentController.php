<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('class')->paginate(20);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        return view('admin.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'nis'          => 'required|string|max:50|unique:students,nis',
            'email'        => 'required|email|unique:users,email',
            'class_id'     => 'nullable|exists:classes,id',
            'address'      => 'nullable|string',
            'parent_phone' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt('password123'),
            'role'     => 'student',
        ]);

        Student::create([
            'user_id'      => $user->id,
            'name'         => $data['name'],
            'nis'          => $data['nis'],
            'class_id'     => $data['class_id'] ?? null,
            'address'      => $data['address'] ?? null,
            'parent_phone' => $data['parent_phone'] ?? null,
            'is_active'    => true,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Murid berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::all();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'nis'          => 'required|string|max:50|unique:students,nis,' . $student->id,
            'email'        => 'required|email|unique:users,email,' . $student->user_id,
            'class_id'     => 'nullable|exists:classes,id',
            'address'      => 'nullable|string',
            'parent_phone' => 'nullable|string|max:50',
            'is_active'    => 'nullable|boolean',
        ]);

        // update user
        $student->user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        // update student
        $student->update([
            'name'         => $data['name'],
            'nis'          => $data['nis'],
            'class_id'     => $data['class_id'] ?? null,
            'address'      => $data['address'] ?? null,
            'parent_phone' => $data['parent_phone'] ?? null,
            'is_active'    => $data['is_active'] ?? $student->is_active,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Data murid berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->user->delete(); // cascade juga hapus student
        return redirect()->route('admin.students.index')->with('success', 'Murid berhasil dihapus.');
    }
}
