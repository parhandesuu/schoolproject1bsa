<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('kategori-berita.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat kategori.');
        }

        $categories = Category::withCount('posts')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        if (!auth()->user()->can('kategori-berita.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah kategori.');
        }

        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('kategori-berita.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah kategori.');
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'slug'      => 'required|string|max:255|unique:categories,slug',
            'color'     => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Category::create($validated);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        if (!auth()->user()->can('kategori-berita.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat kategori.');
        }

        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        if (!auth()->user()->can('kategori-berita.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah kategori.');
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if (!auth()->user()->can('kategori-berita.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah kategori.');
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'slug'      => ['required', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category->id)],
            'color'     => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if (!auth()->user()->can('kategori-berita.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus kategori.');
        }

        if ($category->posts()->exists()) {
            return redirect()->route('admin.categories.index')
                             ->with('error', 'Tidak dapat menghapus kategori yang memiliki postingan.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}
