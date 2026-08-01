<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category', 'user');

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
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
        $categories = Category::where('is_active', true)->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'category_id'      => 'required|exists:categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'thumbnail'        => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'status'           => 'required|in:draft,published,archived',
            'is_featured'      => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'published_at'     => 'nullable|date',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['slug']        = Post::generateSlug($validated['title']);
        $validated['user_id']     = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('posts', 'public');
            $validated['thumbnail'] = $path;
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'category_id'      => 'required|exists:categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'thumbnail'        => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'status'           => 'required|in:draft,published,archived',
            'is_featured'      => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'published_at'     => 'nullable|date',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $path = $request->file('thumbnail')->store('posts', 'public');
            $validated['thumbnail'] = $path;
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')
                         ->with('success', 'Post deleted successfully.');
    }
}
