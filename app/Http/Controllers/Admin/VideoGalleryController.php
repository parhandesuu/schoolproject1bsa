<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoGallery;
use Illuminate\Http\Request;

class VideoGalleryController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('galeri-video.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat galeri video.');
        }

        $videos = VideoGallery::orderBy('order')->paginate(15);
        return view('admin.video-galleries.index', compact('videos'));
    }

    public function create()
    {
        if (!auth()->user()->can('galeri-video.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah video.');
        }

        return view('admin.video-galleries.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('galeri-video.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah video.');
        }

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'youtube_url'  => 'required|url|max:500',
            'order'        => 'required|integer|min:0',
            'is_active'    => 'boolean',
        ]);

        $validated['is_active']  = $request->boolean('is_active');
        $validated['youtube_id'] = VideoGallery::extractYoutubeId($validated['youtube_url']);

        VideoGallery::create($validated);

        return redirect()->route('admin.video-galleries.index')
                         ->with('success', 'Video berhasil ditambahkan.');
    }

    public function show(VideoGallery $videoGallery)
    {
        if (!auth()->user()->can('galeri-video.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat galeri video.');
        }

        return view('admin.video-galleries.show', compact('videoGallery'));
    }

    public function edit(VideoGallery $videoGallery)
    {
        if (!auth()->user()->can('galeri-video.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah video.');
        }

        return view('admin.video-galleries.edit', compact('videoGallery'));
    }

    public function update(Request $request, VideoGallery $videoGallery)
    {
        if (!auth()->user()->can('galeri-video.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah video.');
        }

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'youtube_url'  => 'required|url|max:500',
            'order'        => 'required|integer|min:0',
            'is_active'    => 'boolean',
        ]);

        $validated['is_active']  = $request->boolean('is_active');
        $validated['youtube_id'] = VideoGallery::extractYoutubeId($validated['youtube_url']);

        $videoGallery->update($validated);

        return redirect()->route('admin.video-galleries.index')
                         ->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(VideoGallery $videoGallery)
    {
        if (!auth()->user()->can('galeri-video.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus video.');
        }

        $videoGallery->delete();

        return redirect()->route('admin.video-galleries.index')
                         ->with('success', 'Video berhasil dihapus.');
    }
}
