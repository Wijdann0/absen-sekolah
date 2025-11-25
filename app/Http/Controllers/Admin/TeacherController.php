<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->paginate(20);

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'nip'    => 'nullable|string|max:100',
            'subject'=> 'nullable|string|max:255',
            'email'  => 'required|email|unique:users,email',
            'phone'  => 'nullable|string|max:50',
        ]);

        // Buat user
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt('password123'), // bisa nanti dipaksa ganti
            'role'     => 'teacher',
        ]);

        // Buat teacher
        Teacher::create([
            'user_id' => $user->id,
            'name'    => $data['name'],
            'nip'     => $data['nip'] ?? null,
            'subject' => $data['subject'] ?? null,
            'email'   => $data['email'],
            'phone'   => $data['phone'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'nip'    => 'nullable|string|max:100',
            'subject'=> 'nullable|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $teacher->user_id,
            'phone'  => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        // Update user
        $teacher->user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        // Update teacher
        $teacher->update([
            'name'      => $data['name'],
            'nip'       => $data['nip'] ?? null,
            'subject'   => $data['subject'] ?? null,
            'email'     => $data['email'],
            'phone'     => $data['phone'] ?? null,
            'is_active' => $data['is_active'] ?? $teacher->is_active,
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        // Hapus user-nya sekalian (karena foreign key cascade)
        $teacher->user->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Guru berhasil dihapus.');
    }
}
