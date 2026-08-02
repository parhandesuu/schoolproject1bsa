<?php

namespace App\Http\Controllers;

use App\Models\PhotoAlbum;
use App\Models\VideoGallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a paginated list of active photo albums with photo counts.
     */
    public function photos()
    {
        $albums = PhotoAlbum::where('is_active', true)
            ->withCount('photos')
            ->with(['photos' => function ($query) {
                $query->orderBy('order')->take(1);
            }])
            ->latest()
            ->paginate(9);

        return view('gallery.photos', compact('albums'));
    }

    /**
     * Display a specific photo album with all its photos.
     *
     * @param PhotoAlbum $album
     */
    public function album(PhotoAlbum $album)
    {
        // Ensure the album is active
        abort_if(!$album->is_active, 404);

        $album->load(['photos' => function ($query) {
            $query->orderBy('order');
        }]);

        $photos = $album->photos;

        return view('gallery.album', compact('album', 'photos'));
    }

    /**
     * Display a paginated list of active video galleries.
     */
    public function videos()
    {
        $videos = VideoGallery::where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('gallery.videos', compact('videos'));
    }
}
