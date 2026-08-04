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
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'content'     => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'order'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $validated['image'] = $path;
        }

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
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'content'     => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'order'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $path = $request->file('image')->store('services', 'public');
            $validated['image'] = $path;
        }

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
        $service->delete();

        return redirect()->route('admin.services.index')
                         ->with('success', 'Layanan berhasil dihapus.');
    }
}
