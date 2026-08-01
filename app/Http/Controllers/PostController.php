<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class PostController extends Controller
{
    /**
     * Display a paginated list of published posts.
     * Supports search by title (?q=) and filter by category (?category=).
     */
    public function index(Request $request)
    {
        $query = Post::where('status', 'published')
            ->with('category')
            ->latest('published_at');

        // Search by title
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by category slug
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        $posts = $query->paginate(9)->withQueryString();

        // Load all categories for filter sidebar
        $categories = Category::withCount(['posts' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        return view('posts.index', compact('posts', 'categories'));
    }

    /**
     * Display a single published post by slug.
     * Increments view count and loads approved comments + related posts.
     */
    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view count
        $post->increment('views');

        // Load approved comments
        $post->load(['approvedComments' => function ($query) {
            $query->latest();
        }]);

        // Load related posts (same category, excluding current, latest 3)
        $relatedPosts = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        // If not enough related posts in same category, fill with latest posts
        if ($relatedPosts->count() < 3) {
            $existingIds = $relatedPosts->pluck('id')->push($post->id);
            $additionalPosts = Post::where('status', 'published')
                ->whereNotIn('id', $existingIds)
                ->with('category')
                ->latest('published_at')
                ->take(3 - $relatedPosts->count())
                ->get();
            $relatedPosts = $relatedPosts->merge($additionalPosts);
        }

        return view('posts.show', compact('post', 'relatedPosts'));
    }

    /**
     * Store a new comment for a post.
     * Comment is created with status=pending awaiting moderation.
     */
    public function storeComment(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'content' => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        $post->comments()->create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'content'    => $validated['content'],
            'status'     => 'pending',
            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Komentar Anda berhasil dikirim dan sedang menunggu moderasi.');
    }
}
