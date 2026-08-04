<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('fasilitas.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat data fasilitas.');
        }

        $facilities = Facility::orderBy('order')->paginate(15);
        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        if (!auth()->user()->can('fasilitas.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah fasilitas.');
        }

        return view('admin.facilities.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('fasilitas.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah fasilitas.');
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'icon'        => 'nullable|string|max:100',
            'order'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('facilities', 'public');
            $validated['image'] = $path;
        }

        Facility::create($validated);

        return redirect()->route('admin.facilities.index')
                         ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function show(Facility $facility)
    {
        if (!auth()->user()->can('fasilitas.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat data fasilitas.');
        }

        return view('admin.facilities.show', compact('facility'));
    }

    public function edit(Facility $facility)
    {
        if (!auth()->user()->can('fasilitas.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah fasilitas.');
        }

        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        if (!auth()->user()->can('fasilitas.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah fasilitas.');
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'icon'        => 'nullable|string|max:100',
            'order'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($facility->image) {
                Storage::disk('public')->delete($facility->image);
            }
            $path = $request->file('image')->store('facilities', 'public');
            $validated['image'] = $path;
        }

        $facility->update($validated);

        return redirect()->route('admin.facilities.index')
                         ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        if (!auth()->user()->can('fasilitas.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus fasilitas.');
        }

        if ($facility->image) {
            Storage::disk('public')->delete($facility->image);
        }
        $facility->delete();

        return redirect()->route('admin.facilities.index')
                         ->with('success', 'Fasilitas berhasil dihapus.');
    }
}
