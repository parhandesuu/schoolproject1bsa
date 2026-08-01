<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExtracurricularController extends Controller
{
    public function index()
    {
        $extracurriculars = Extracurricular::orderBy('order')->paginate(15);
        return view('admin.extracurriculars.index', compact('extracurriculars'));
    }

    public function create()
    {
        return view('admin.extracurriculars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'schedule'    => 'nullable|string|max:255',
            'teacher'     => 'nullable|string|max:255',
            'order'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('extracurriculars', 'public');
            $validated['image'] = $path;
        }

        Extracurricular::create($validated);

        return redirect()->route('admin.extracurriculars.index')
                         ->with('success', 'Extracurricular created successfully.');
    }

    public function show(Extracurricular $extracurricular)
    {
        return view('admin.extracurriculars.show', compact('extracurricular'));
    }

    public function edit(Extracurricular $extracurricular)
    {
        return view('admin.extracurriculars.edit', compact('extracurricular'));
    }

    public function update(Request $request, Extracurricular $extracurricular)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'schedule'    => 'nullable|string|max:255',
            'teacher'     => 'nullable|string|max:255',
            'order'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($extracurricular->image) {
                Storage::disk('public')->delete($extracurricular->image);
            }
            $path = $request->file('image')->store('extracurriculars', 'public');
            $validated['image'] = $path;
        }

        $extracurricular->update($validated);

        return redirect()->route('admin.extracurriculars.index')
                         ->with('success', 'Extracurricular updated successfully.');
    }

    public function destroy(Extracurricular $extracurricular)
    {
        if ($extracurricular->image) {
            Storage::disk('public')->delete($extracurricular->image);
        }
        $extracurricular->delete();

        return redirect()->route('admin.extracurriculars.index')
                         ->with('success', 'Extracurricular deleted successfully.');
    }
}
