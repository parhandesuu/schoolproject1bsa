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
        return redirect()->route('admin.photo-albums.show', $photoAlbum->id);
    }

    public function store(Request $request, PhotoAlbum $photoAlbum)
    {
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
                         ->with('success', 'Photos uploaded successfully.');
    }

    public function destroy(PhotoGallery $photo)
    {
        if ($photo->image) {
            Storage::disk('public')->delete($photo->image);
        }
        $albumId = $photo->photo_album_id;
        $photo->delete();

        return redirect()->route('admin.photo-albums.show', $albumId)
                         ->with('success', 'Photo deleted successfully.');
    }
}
