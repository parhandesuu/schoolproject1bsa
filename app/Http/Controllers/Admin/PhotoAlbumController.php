<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhotoAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoAlbumController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('galeri-foto.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat album galeri.');
        }

        $albums = PhotoAlbum::withCount('photos')->latest()->paginate(15);
        return view('admin.photo-albums.index', compact('albums'));
    }

    public function create()
    {
        if (!auth()->user()->can('galeri-foto.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah album galeri.');
        }

        return view('admin.photo-albums.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('galeri-foto.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah album galeri.');
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('albums', 'public');
            $validated['cover'] = $path;
        }

        PhotoAlbum::create($validated);

        return redirect()->route('admin.photo-albums.index')
                         ->with('success', 'Album foto berhasil ditambahkan.');
    }

    public function show(PhotoAlbum $photoAlbum)
    {
        if (!auth()->user()->can('galeri-foto.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat album galeri.');
        }

        return view('admin.photo-albums.show', ['album' => $photoAlbum]);
    }

    public function edit(PhotoAlbum $photoAlbum)
    {
        if (!auth()->user()->can('galeri-foto.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah album galeri.');
        }

        return view('admin.photo-albums.edit', ['album' => $photoAlbum]);
    }

    public function update(Request $request, PhotoAlbum $photoAlbum)
    {
        if (!auth()->user()->can('galeri-foto.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah album galeri.');
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('cover')) {
            if ($photoAlbum->cover) {
                Storage::disk('public')->delete($photoAlbum->cover);
            }
            $path = $request->file('cover')->store('albums', 'public');
            $validated['cover'] = $path;
        }

        $photoAlbum->update($validated);

        return redirect()->route('admin.photo-albums.index')
                         ->with('success', 'Album foto berhasil diperbarui.');
    }

    public function destroy(PhotoAlbum $photoAlbum)
    {
        if (!auth()->user()->can('galeri-foto.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus album galeri.');
        }

        // Delete all photos in album
        foreach ($photoAlbum->photos as $photo) {
            Storage::disk('public')->delete($photo->image);
            $photo->delete();
        }

        if ($photoAlbum->cover) {
            Storage::disk('public')->delete($photoAlbum->cover);
        }

        $photoAlbum->delete();

        return redirect()->route('admin.photo-albums.index')
                         ->with('success', 'Album foto berhasil dihapus.');
    }
}
