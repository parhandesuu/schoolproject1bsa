<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('medsos.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat media sosial.');
        }

        $socialMedia = SocialMedia::orderBy('order')->paginate(15);
        $socialMedias = $socialMedia;
        return view('admin.social-media.index', compact('socialMedia', 'socialMedias'));
    }

    public function create()
    {
        if (!auth()->user()->can('medsos.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah media sosial.');
        }

        return view('admin.social-media.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('medsos.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah media sosial.');
        }

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
                         ->with('success', 'Media sosial berhasil ditambahkan.');
    }

    public function show(SocialMedia $socialMedia)
    {
        if (!auth()->user()->can('medsos.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat media sosial.');
        }

        return view('admin.social-media.show', compact('socialMedia'));
    }

    public function edit(SocialMedia $socialMedia)
    {
        if (!auth()->user()->can('medsos.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah media sosial.');
        }

        return view('admin.social-media.edit', compact('socialMedia'));
    }

    public function update(Request $request, SocialMedia $socialMedia)
    {
        if (!auth()->user()->can('medsos.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah media sosial.');
        }

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
                         ->with('success', 'Media sosial berhasil diperbarui.');
    }

    public function destroy(SocialMedia $socialMedia)
    {
        if (!auth()->user()->can('medsos.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus media sosial.');
        }

        $socialMedia->delete();

        return redirect()->route('admin.social-media.index')
                         ->with('success', 'Media sosial berhasil dihapus.');
    }
}
