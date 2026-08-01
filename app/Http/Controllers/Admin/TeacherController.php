<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::orderBy('order')->paginate(15);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'nip'       => 'nullable|string|max:100|unique:teachers,nip',
            'position'  => 'required|string|max:255',
            'subject'   => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'photo'     => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'bio'       => 'nullable|string',
            'type'      => 'required|in:teacher,staff',
            'order'     => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('teachers', 'public');
            $validated['photo'] = $path;
        }

        Teacher::create($validated);

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Teacher created successfully.');
    }

    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'nip'       => ['nullable', 'string', 'max:100', Rule::unique('teachers', 'nip')->ignore($teacher->id)],
            'position'  => 'required|string|max:255',
            'subject'   => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'photo'     => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'bio'       => 'nullable|string',
            'type'      => 'required|in:teacher,staff',
            'order'     => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            if ($teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }
            $path = $request->file('photo')->store('teachers', 'public');
            $validated['photo'] = $path;
        }

        $teacher->update($validated);

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }
        $teacher->delete();

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Teacher deleted successfully.');
    }
}
