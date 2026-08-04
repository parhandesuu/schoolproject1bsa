<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Notifications\ContentReviewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('berita.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat daftar berita.');
        }

        $query = Post::with('category', 'user');

        // Staff only sees their own posts if they don't have broader view permission
        if (auth()->user()->hasRole('staff') && !auth()->user()->hasAnyRole(['admin', 'editor'])) {
            $query->where('user_id', auth()->id());
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($category = $request->input('category_id')) {
            $query->where('category_id', $category);
        }

        $posts      = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        if (!auth()->user()->can('berita.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk membuat berita.');
        }

        $categories = Category::where('is_active', true)->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('berita.create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk membuat berita.');
        }

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'category_id'      => 'required|exists:categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'thumbnail'        => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'status'           => 'required|in:draft,pending_review,published,archived',
            'is_featured'      => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'published_at'     => 'nullable|date',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['slug']        = Post::generateSlug($validated['title']);
        $validated['user_id']     = auth()->id();

        // Check if user has permission to publish directly
        if (!auth()->user()->can('berita.publish') && $validated['status'] === 'published') {
            $validated['status'] = 'pending_review';
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = $validated['published_at'] ?? now();
            $validated['reviewed_by'] = auth()->id();
            $validated['reviewed_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('posts', 'public');
            $validated['thumbnail'] = $path;
        }

        $post = Post::create($validated);

        // Notify admins if submitted for review
        if ($post->status === 'pending_review') {
            $admins = User::role('admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new ContentReviewNotification(
                    'berita',
                    $post->id,
                    $post->title,
                    auth()->user()->name,
                    route('admin.approvals.posts')
                ));
            }
        }

        $msg = $post->status === 'pending_review'
            ? 'Artikel berhasil disimpan dan diajukan untuk ditinjau oleh Admin.'
            : 'Artikel berhasil disimpan.';

        return redirect()->route('admin.posts.index')->with('success', $msg);
    }

    public function show(Post $post)
    {
        if (!auth()->user()->can('berita.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat berita.');
        }

        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if (!auth()->user()->can('berita.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah berita.');
        }

        // Staff can only edit their own posts
        if (auth()->user()->hasRole('staff') && !auth()->user()->hasAnyRole(['admin', 'editor'])) {
            if ($post->user_id !== auth()->id()) {
                abort(403, 'Anda hanya dapat mengubah artikel yang Anda buat sendiri.');
            }
        }

        $categories = Category::where('is_active', true)->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        if (!auth()->user()->can('berita.update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah berita.');
        }

        // Staff can only edit their own posts
        if (auth()->user()->hasRole('staff') && !auth()->user()->hasAnyRole(['admin', 'editor'])) {
            if ($post->user_id !== auth()->id()) {
                abort(403, 'Anda hanya dapat mengubah artikel yang Anda buat sendiri.');
            }
        }

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'category_id'      => 'required|exists:categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'thumbnail'        => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'status'           => 'required|in:draft,pending_review,published,archived,rejected',
            'is_featured'      => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'published_at'     => 'nullable|date',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        // Check if user has permission to publish directly
        if (!auth()->user()->can('berita.publish') && $validated['status'] === 'published') {
            $validated['status'] = 'pending_review';
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = $validated['published_at'] ?? $post->published_at ?? now();
            $validated['reviewed_by'] = auth()->id();
            $validated['reviewed_at'] = now();
            $validated['rejection_note'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $path = $request->file('thumbnail')->store('posts', 'public');
            $validated['thumbnail'] = $path;
        }

        $post->update($validated);

        // Notify admins if status changed to pending_review
        if ($post->status === 'pending_review') {
            $admins = User::role('admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new ContentReviewNotification(
                    'berita',
                    $post->id,
                    $post->title,
                    auth()->user()->name,
                    route('admin.approvals.posts')
                ));
            }
        }

        $msg = $post->status === 'pending_review'
            ? 'Artikel berhasil diperbarui dan diajukan untuk ditinjau oleh Admin.'
            : 'Artikel berhasil diperbarui.';

        return redirect()->route('admin.posts.index')->with('success', $msg);
    }

    public function destroy(Post $post)
    {
        if (!auth()->user()->can('berita.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus berita.');
        }

        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Artikel berhasil dihapus.');
    }
}
