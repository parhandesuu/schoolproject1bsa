<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function index()
    {
        $logos = Logo::orderBy('order')->paginate(15);
        return view('admin.logos.index', compact('logos'));
    }

    public function create()
    {
        return view('admin.logos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'image'     => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'type'      => 'required|in:school,twh,yayasan,education',
            'order'     => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('logos', 'public');
            $validated['image'] = $path;
        }

        Logo::create($validated);

        return redirect()->route('admin.logos.index')
                         ->with('success', 'Logo created successfully.');
    }

    public function show(Logo $logo)
    {
        return view('admin.logos.show', compact('logo'));
    }

    public function edit(Logo $logo)
    {
        return view('admin.logos.edit', compact('logo'));
    }

    public function update(Request $request, Logo $logo)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'image'     => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'type'      => 'required|in:school,twh,yayasan,education',
            'order'     => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($logo->image) {
                Storage::disk('public')->delete($logo->image);
            }
            $path = $request->file('image')->store('logos', 'public');
            $validated['image'] = $path;
        }

        $logo->update($validated);

        return redirect()->route('admin.logos.index')
                         ->with('success', 'Logo updated successfully.');
    }

    public function destroy(Logo $logo)
    {
        if ($logo->image) {
            Storage::disk('public')->delete($logo->image);
        }
        $logo->delete();

        return redirect()->route('admin.logos.index')
                         ->with('success', 'Logo deleted successfully.');
    }
}
