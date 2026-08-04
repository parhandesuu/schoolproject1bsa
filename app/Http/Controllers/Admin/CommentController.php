<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('komentar.read')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat komentar.');
        }

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
        if (!auth()->user()->can('komentar.approve')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menyetujui komentar.');
        }

        $comment->update(['status' => 'approved']);

        return redirect()->back()
                         ->with('success', 'Komentar berhasil disetujui.');
    }

    public function reject(Comment $comment)
    {
        if (!auth()->user()->can('komentar.approve')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menolak komentar.');
        }

        $comment->update(['status' => 'rejected']);

        return redirect()->back()
                         ->with('success', 'Komentar berhasil ditolak.');
    }

    public function destroy(Comment $comment)
    {
        if (!auth()->user()->can('komentar.delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus komentar.');
        }

        $comment->delete();

        return redirect()->route('admin.comments.index')
                         ->with('success', 'Komentar berhasil dihapus.');
    }
}
