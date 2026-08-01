<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Teacher;
use App\Models\Achievement;
use App\Models\Extracurricular;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts'            => Post::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'unread_contacts'  => Contact::where('status', 'unread')->count(),
            'teachers'         => Teacher::count(),
            'achievements'     => Achievement::count(),
            'extracurriculars' => Extracurricular::count(),
            'announcements'    => Announcement::where('is_active', true)->count(),
        ];

        $latestPosts    = Post::with('category', 'user')->latest()->take(5)->get();
        $latestContacts = Contact::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestPosts', 'latestContacts'));
    }
}
