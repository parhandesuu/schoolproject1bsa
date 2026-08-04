<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhotoAlbum;
use App\Models\PhotoGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoGalleryController extends Controller
{
    public function index(PhotoAlbum $photoAlbum)
    {
        if (!auth()->user()->can('galeri-foto.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat galeri foto.');
        }

        return redirect()->route('admin.photo-albums.show', $photoAlbum->id);
    }

    public function store(Request $request, PhotoAlbum $photoAlbum)
    {
        if (!auth()->user()->can('galeri-foto.create') && !auth()->user()->can('galeri-foto.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengunggah foto ke album.');
        }

        $album = $photoAlbum;
        $request->validate([
            'images'   => 'required|array|min:1',
            'images.*' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        foreach ($request->file('images') as $file) {
            $path = $file->store('galleries', 'public');

            $album->photos()->create([
                'image'    => $path,
                'caption'  => null,
                'order'    => 0,
            ]);
        }

        return redirect()->route('admin.photo-albums.show', $album->id)
                         ->with('success', 'Foto berhasil diunggah.');
    }

    public function destroy(PhotoGallery $photo)
    {
        if (!auth()->user()->can('galeri-foto.delete') && !auth()->user()->can('galeri-foto.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus foto galeri.');
        }

        if ($photo->image) {
            Storage::disk('public')->delete($photo->image);
        }
        $albumId = $photo->photo_album_id;
        $photo->delete();

        return redirect()->route('admin.photo-albums.show', $albumId)
                         ->with('success', 'Foto berhasil dihapus.');
    }
}
