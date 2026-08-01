<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSliderController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::orderBy('order')->paginate(15);
        return view('admin.hero-sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.hero-sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:500',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_url'  => 'nullable|string|max:255',
            'button_text_2' => 'nullable|string|max:100',
            'button_url_2'  => 'nullable|string|max:255',
            'order'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hero-sliders', 'public');
            $validated['image'] = $path;
        }

        HeroSlider::create($validated);

        return redirect()->route('admin.hero-sliders.index')
                         ->with('success', 'Hero slider created successfully.');
    }

    public function show(HeroSlider $heroSlider)
    {
        return view('admin.hero-sliders.show', compact('heroSlider'));
    }

    public function edit(HeroSlider $heroSlider)
    {
        return view('admin.hero-sliders.edit', ['slider' => $heroSlider]);
    }

    public function update(Request $request, HeroSlider $heroSlider)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:500',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_url'  => 'nullable|string|max:255',
            'button_text_2' => 'nullable|string|max:100',
            'button_url_2'  => 'nullable|string|max:255',
            'order'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($heroSlider->image) {
                Storage::disk('public')->delete($heroSlider->image);
            }
            $path = $request->file('image')->store('hero-sliders', 'public');
            $validated['image'] = $path;
        }

        $heroSlider->update($validated);

        return redirect()->route('admin.hero-sliders.index')
                         ->with('success', 'Hero slider updated successfully.');
    }

    public function destroy(HeroSlider $heroSlider)
    {
        if ($heroSlider->image) {
            Storage::disk('public')->delete($heroSlider->image);
        }
        $heroSlider->delete();

        return redirect()->route('admin.hero-sliders.index')
                         ->with('success', 'Hero slider deleted successfully.');
    }
}
