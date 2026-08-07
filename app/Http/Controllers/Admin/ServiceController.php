<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('layanan.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat layanan.');
        }

        $services = Service::orderBy('order')->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        if (!auth()->user()->can('layanan.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah layanan.');
        }

        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('layanan.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah layanan.');
        }

        $validated = $request->validate([
            'title'                => 'required|string|max:255',
            'description'          => 'nullable|string',
            'content'              => 'nullable|string',
            'icon'                 => 'nullable|string|max:100',
            'image'                => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:5120',
            'image_title'          => 'nullable|string|max:255',
            'file'                 => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,txt|max:10240',
            'new_gallery_images'   => 'nullable|array',
            'new_gallery_images.*' => 'file|mimes:jpg,jpeg,png,webp,svg|max:5120',
            'new_gallery_titles'   => 'nullable|array',
            'new_gallery_titles.*' => 'nullable|string|max:255',
            'images'               => 'nullable|array',
            'images.*'             => 'file|mimes:jpg,jpeg,png,webp,svg|max:5120',
            'order'                => 'required|integer|min:0',
            'is_active'            => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // Main image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $validated['image'] = $path;
        }

        // Document attachment
        if ($request->hasFile('file')) {
            $uploaded = $request->file('file');
            $validated['file_name'] = $uploaded->getClientOriginalName();
            $validated['file'] = $uploaded->store('services/files', 'public');
        }

        // Additional gallery photos with titles
        $gallery = [];
        if ($request->hasFile('new_gallery_images')) {
            $newImages = $request->file('new_gallery_images');
            $newTitles = $request->input('new_gallery_titles', []);
            foreach ($newImages as $idx => $img) {
                if ($img && $img->isValid()) {
                    $path = $img->store('services/gallery', 'public');
                    $gallery[] = [
                        'path'  => $path,
                        'title' => $newTitles[$idx] ?? null,
                    ];
                }
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if ($img && $img->isValid()) {
                    $gallery[] = [
                        'path'  => $img->store('services/gallery', 'public'),
                        'title' => null,
                    ];
                }
            }
        }

        $validated['images'] = !empty($gallery) ? $gallery : null;

        Service::create($validated);

        return redirect()->route('admin.services.index')
                         ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function show(Service $service)
    {
        if (!auth()->user()->can('layanan.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat layanan.');
        }

        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        if (!auth()->user()->can('layanan.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah layanan.');
        }

        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        if (!auth()->user()->can('layanan.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah layanan.');
        }

        $validated = $request->validate([
            'title'                   => 'required|string|max:255',
            'description'             => 'nullable|string',
            'content'                 => 'nullable|string',
            'icon'                    => 'nullable|string|max:100',
            'image'                   => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:5120',
            'image_title'             => 'nullable|string|max:255',
            'remove_image'            => 'nullable|boolean',
            'file'                    => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,txt|max:10240',
            'remove_file'             => 'nullable|boolean',
            'existing_image_paths'    => 'nullable|array',
            'existing_image_titles'   => 'nullable|array',
            'existing_image_titles.*' => 'nullable|string|max:255',
            'new_gallery_images'      => 'nullable|array',
            'new_gallery_images.*'    => 'file|mimes:jpg,jpeg,png,webp,svg|max:5120',
            'new_gallery_titles'      => 'nullable|array',
            'new_gallery_titles.*'    => 'nullable|string|max:255',
            'images'                  => 'nullable|array',
            'images.*'                => 'file|mimes:jpg,jpeg,png,webp,svg|max:5120',
            'remove_images'           => 'nullable|array',
            'remove_images.*'         => 'string',
            'order'                   => 'required|integer|min:0',
            'is_active'               => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // Main image remove / replace
        if ($request->boolean('remove_image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $path = $request->file('image')->store('services', 'public');
            $validated['image'] = $path;
        }

        // File attachment remove / replace
        if ($request->boolean('remove_file')) {
            if ($service->file) {
                Storage::disk('public')->delete($service->file);
            }
            $validated['file'] = null;
            $validated['file_name'] = null;
        }

        if ($request->hasFile('file')) {
            if ($service->file) {
                Storage::disk('public')->delete($service->file);
            }
            $uploaded = $request->file('file');
            $validated['file_name'] = $uploaded->getClientOriginalName();
            $validated['file'] = $uploaded->store('services/files', 'public');
        }

        // Additional gallery photos
        $gallery = [];
        $removeImages = $request->input('remove_images', []);

        // 1. Existing photos & their updated titles
        $existingPaths = $request->input('existing_image_paths', []);
        $existingTitles = $request->input('existing_image_titles', []);

        if (is_array($existingPaths)) {
            foreach ($existingPaths as $idx => $path) {
                if (in_array($path, $removeImages)) {
                    Storage::disk('public')->delete($path);
                } else {
                    $gallery[] = [
                        'path'  => $path,
                        'title' => $existingTitles[$idx] ?? null,
                    ];
                }
            }
        }

        // 2. New gallery images from repeater
        if ($request->hasFile('new_gallery_images')) {
            $newImages = $request->file('new_gallery_images');
            $newTitles = $request->input('new_gallery_titles', []);
            foreach ($newImages as $idx => $img) {
                if ($img && $img->isValid()) {
                    $path = $img->store('services/gallery', 'public');
                    $gallery[] = [
                        'path'  => $path,
                        'title' => $newTitles[$idx] ?? null,
                    ];
                }
            }
        }

        // 3. Fallback for legacy multi-upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if ($img && $img->isValid()) {
                    $gallery[] = [
                        'path'  => $img->store('services/gallery', 'public'),
                        'title' => null,
                    ];
                }
            }
        }

        $validated['images'] = !empty($gallery) ? array_values($gallery) : null;

        $service->update($validated);

        return redirect()->route('admin.services.index')
                         ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if (!auth()->user()->can('layanan.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus layanan.');
        }

        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        if ($service->file) {
            Storage::disk('public')->delete($service->file);
        }
        if (!empty($service->images) && is_array($service->images)) {
            foreach ($service->images as $img) {
                $imgPath = is_array($img) ? ($img['path'] ?? null) : $img;
                if ($imgPath) {
                    Storage::disk('public')->delete($imgPath);
                }
            }
        }

        $service->delete();

        return redirect()->route('admin.services.index')
                         ->with('success', 'Layanan berhasil dihapus.');
    }
}
