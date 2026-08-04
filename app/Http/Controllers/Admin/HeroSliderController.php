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
        if (!auth()->user()->can('slider.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat slider banner.');
        }

        $sliders = HeroSlider::orderBy('order')->paginate(15);
        return view('admin.hero-sliders.index', compact('sliders'));
    }

    public function create()
    {
        if (!auth()->user()->can('slider.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah slider banner.');
        }

        return view('admin.hero-sliders.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('slider.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah slider banner.');
        }

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
                         ->with('success', 'Banner slider berhasil ditambahkan.');
    }

    public function show(HeroSlider $heroSlider)
    {
        if (!auth()->user()->can('slider.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat slider banner.');
        }

        return view('admin.hero-sliders.show', compact('heroSlider'));
    }

    public function edit(HeroSlider $heroSlider)
    {
        if (!auth()->user()->can('slider.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah slider banner.');
        }

        return view('admin.hero-sliders.edit', ['slider' => $heroSlider]);
    }

    public function update(Request $request, HeroSlider $heroSlider)
    {
        if (!auth()->user()->can('slider.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah slider banner.');
        }

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
                         ->with('success', 'Banner slider berhasil diperbarui.');
    }

    public function destroy(HeroSlider $heroSlider)
    {
        if (!auth()->user()->can('slider.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus slider banner.');
        }

        if ($heroSlider->image) {
            Storage::disk('public')->delete($heroSlider->image);
        }
        $heroSlider->delete();

        return redirect()->route('admin.hero-sliders.index')
                         ->with('success', 'Banner slider berhasil dihapus.');
    }
}
