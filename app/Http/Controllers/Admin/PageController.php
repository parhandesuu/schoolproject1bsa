<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:pages,slug',
            'content'          => 'required|string',
            'excerpt'          => 'nullable|string|max:500',
            'image'            => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active'        => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('pages', 'public');
            $validated['image'] = $path;
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')
                         ->with('success', 'Page created successfully.');
    }

    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => ['required', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($page->id)],
            'content'          => 'required|string',
            'excerpt'          => 'nullable|string|max:500',
            'image'            => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active'        => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($page->image) {
                Storage::disk('public')->delete($page->image);
            }
            $path = $request->file('image')->store('pages', 'public');
            $validated['image'] = $path;
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')
                         ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        if ($page->image) {
            Storage::disk('public')->delete($page->image);
        }
        $page->delete();

        return redirect()->route('admin.pages.index')
                         ->with('success', 'Page deleted successfully.');
    }
}
