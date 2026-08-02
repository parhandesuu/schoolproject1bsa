<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with('post');

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $query->whereHas('post', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })->orWhere('content', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%");
        }

        $comments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return redirect()->back()
                         ->with('success', 'Comment approved successfully.');
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);

        return redirect()->back()
                         ->with('success', 'Comment rejected successfully.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')
                         ->with('success', 'Comment deleted successfully.');
    }
}
