<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function index()
    {
        $socialMedias = SocialMedia::orderBy('order')->paginate(15);
        return view('admin.social-media.index', compact('socialMedias'));
    }

    public function create()
    {
        return view('admin.social-media.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'url'       => 'required|url|max:500',
            'icon'      => 'nullable|string|max:100',
            'color'     => 'nullable|string|max:50',
            'order'     => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        SocialMedia::create($validated);

        return redirect()->route('admin.social-media.index')
                         ->with('success', 'Social media link created successfully.');
    }

    public function show(SocialMedia $socialMedia)
    {
        return view('admin.social-media.show', compact('socialMedia'));
    }

    public function edit(SocialMedia $socialMedia)
    {
        return view('admin.social-media.edit', compact('socialMedia'));
    }

    public function update(Request $request, SocialMedia $socialMedia)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'url'       => 'required|url|max:500',
            'icon'      => 'nullable|string|max:100',
            'color'     => 'nullable|string|max:50',
            'order'     => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $socialMedia->update($validated);

        return redirect()->route('admin.social-media.index')
                         ->with('success', 'Social media link updated successfully.');
    }

    public function destroy(SocialMedia $socialMedia)
    {
        $socialMedia->delete();

        return redirect()->route('admin.social-media.index')
                         ->with('success', 'Social media link deleted successfully.');
    }
}
