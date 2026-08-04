<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use App\Notifications\ContentReviewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('halaman-statis.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat halaman statis.');
        }

        $pages = Page::latest()->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        if (!auth()->user()->can('halaman-statis.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah halaman statis.');
        }

        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('halaman-statis.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah halaman statis.');
        }

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
        $validated['last_updated_by'] = auth()->id();

        if (!auth()->user()->can('halaman-statis.publish')) {
            $validated['status'] = 'pending_review';
        } else {
            $validated['status'] = 'published';
            $validated['reviewed_by'] = auth()->id();
            $validated['reviewed_at'] = now();
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('pages', 'public');
            $validated['image'] = $path;
        }

        $page = Page::create($validated);

        if ($page->status === 'pending_review') {
            $admins = User::role('admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new ContentReviewNotification(
                    'halaman',
                    $page->id,
                    $page->title,
                    auth()->user()->name,
                    route('admin.approvals.pages')
                ));
            }
        }

        return redirect()->route('admin.pages.index')
                         ->with('success', 'Halaman berhasil disimpan.');
    }

    public function show(Page $page)
    {
        if (!auth()->user()->can('halaman-statis.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat halaman statis.');
        }

        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        if (!auth()->user()->can('halaman-statis.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah halaman statis.');
        }

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        if (!auth()->user()->can('halaman-statis.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah halaman statis.');
        }

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
        $validated['last_updated_by'] = auth()->id();

        if (!auth()->user()->can('halaman-statis.publish')) {
            $validated['status'] = 'pending_review';
        } else {
            $validated['status'] = 'published';
            $validated['reviewed_by'] = auth()->id();
            $validated['reviewed_at'] = now();
            $validated['rejection_note'] = null;
        }

        if ($request->hasFile('image')) {
            if ($page->image) {
                Storage::disk('public')->delete($page->image);
            }
            $path = $request->file('image')->store('pages', 'public');
            $validated['image'] = $path;
        }

        $page->update($validated);

        if ($page->status === 'pending_review') {
            $admins = User::role('admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new ContentReviewNotification(
                    'halaman',
                    $page->id,
                    $page->title,
                    auth()->user()->name,
                    route('admin.approvals.pages')
                ));
            }
        }

        $msg = $page->status === 'pending_review'
            ? 'Perubahan halaman berhasil diajukan dan menunggu persetujuan Admin.'
            : 'Halaman berhasil diperbarui.';

        return redirect()->route('admin.pages.index')->with('success', $msg);
    }

    public function destroy(Page $page)
    {
        if (!auth()->user()->can('halaman-statis.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus halaman statis.');
        }

        if ($page->image) {
            Storage::disk('public')->delete($page->image);
        }
        $page->delete();

        return redirect()->route('admin.pages.index')
                         ->with('success', 'Halaman berhasil dihapus.');
    }
}
