<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('prestasi.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat data prestasi.');
        }

        $achievements = Achievement::orderBy('order')->paginate(15);
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        if (!auth()->user()->can('prestasi.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah prestasi.');
        }

        return view('admin.achievements.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('prestasi.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah prestasi.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'level'       => 'nullable|string|max:100',
            'category'    => 'nullable|string|max:100',
            'year'        => 'nullable|integer|min:2000|max:2099',
            'order'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('achievements', 'public');
            $validated['image'] = $path;
        }

        Achievement::create($validated);

        return redirect()->route('admin.achievements.index')
                         ->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function show(Achievement $achievement)
    {
        if (!auth()->user()->can('prestasi.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat prestasi.');
        }

        return view('admin.achievements.show', compact('achievement'));
    }

    public function edit(Achievement $achievement)
    {
        if (!auth()->user()->can('prestasi.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah prestasi.');
        }

        return view('admin.achievements.edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        if (!auth()->user()->can('prestasi.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah prestasi.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'level'       => 'nullable|string|max:100',
            'category'    => 'nullable|string|max:100',
            'year'        => 'nullable|integer|min:2000|max:2099',
            'order'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($achievement->image) {
                Storage::disk('public')->delete($achievement->image);
            }
            $path = $request->file('image')->store('achievements', 'public');
            $validated['image'] = $path;
        }

        $achievement->update($validated);

        return redirect()->route('admin.achievements.index')
                         ->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Achievement $achievement)
    {
        if (!auth()->user()->can('prestasi.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus prestasi.');
        }

        if ($achievement->image) {
            Storage::disk('public')->delete($achievement->image);
        }
        $achievement->delete();

        return redirect()->route('admin.achievements.index')
                         ->with('success', 'Prestasi berhasil dihapus.');
    }
}
