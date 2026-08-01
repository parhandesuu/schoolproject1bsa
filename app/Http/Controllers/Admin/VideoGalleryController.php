<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoGallery;
use Illuminate\Http\Request;

class VideoGalleryController extends Controller
{
    public function index()
    {
        $videos = VideoGallery::orderBy('order')->paginate(15);
        return view('admin.video-galleries.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.video-galleries.create');
    }

    public function store(Request $request)
    {
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
                         ->with('success', 'Video created successfully.');
    }

    public function show(VideoGallery $videoGallery)
    {
        return view('admin.video-galleries.show', compact('videoGallery'));
    }

    public function edit(VideoGallery $videoGallery)
    {
        return view('admin.video-galleries.edit', compact('videoGallery'));
    }

    public function update(Request $request, VideoGallery $videoGallery)
    {
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
                         ->with('success', 'Video updated successfully.');
    }

    public function destroy(VideoGallery $videoGallery)
    {
        $videoGallery->delete();

        return redirect()->route('admin.video-galleries.index')
                         ->with('success', 'Video deleted successfully.');
    }
}
