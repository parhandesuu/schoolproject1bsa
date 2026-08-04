<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Page;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('berita.approve') && !auth()->user()->can('halaman-statis.approve')) {
            abort(403, 'Anda tidak memiliki hak akses ke pusat persetujuan.');
        }

        $pendingPosts = Post::with(['category', 'user'])
            ->where('status', 'pending_review')
            ->latest('updated_at')
            ->paginate(15, ['*'], 'posts_page');

        $pendingPages = Page::with(['reviewer', 'lastUpdatedBy'])
            ->where('status', 'pending_review')
            ->latest('updated_at')
            ->paginate(15, ['*'], 'pages_page');

        return view('admin.approvals.index', compact('pendingPosts', 'pendingPages'));
    }

    public function posts()
    {
        return $this->index();
    }

    public function pages()
    {
        return $this->index();
    }

    public function approvePost(Post $post)
    {
        if (!auth()->user()->can('berita.approve')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menyetujui artikel berita.');
        }

        $post->update([
            'status' => 'published',
            'published_at' => $post->published_at ?? now(),
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_note' => null,
        ]);

        return redirect()->route('admin.approvals.index')
            ->with('success', "Artikel '{$post->title}' berhasil disetujui dan dipublikasikan.");
    }

    public function rejectPost(Request $request, Post $post)
    {
        if (!auth()->user()->can('berita.approve')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menolak artikel berita.');
        }

        $request->validate([
            'rejection_note' => 'required|string|max:1000',
        ], [
            'rejection_note.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $post->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_note' => $request->rejection_note,
        ]);

        return redirect()->route('admin.approvals.index')
            ->with('success', "Artikel '{$post->title}' telah ditolak dengan catatan.");
    }

    public function approvePage(Page $page)
    {
        if (!auth()->user()->can('halaman-statis.approve')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menyetujui halaman statis.');
        }

        $page->update([
            'status' => 'published',
            'is_active' => true,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_note' => null,
        ]);

        return redirect()->route('admin.approvals.index')
            ->with('success', "Halaman '{$page->title}' berhasil disetujui dan dipublikasikan.");
    }

    public function rejectPage(Request $request, Page $page)
    {
        if (!auth()->user()->can('halaman-statis.approve')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menolak halaman statis.');
        }

        $request->validate([
            'rejection_note' => 'required|string|max:1000',
        ], [
            'rejection_note.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $page->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_note' => $request->rejection_note,
        ]);

        return redirect()->route('admin.approvals.index')
            ->with('success', "Perubahan halaman '{$page->title}' ditolak dengan catatan.");
    }
}
