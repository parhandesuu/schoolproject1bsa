<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a paginated list of active announcements.
     * Pinned announcements appear first, then ordered by latest.
     */
    public function index()
    {
        $announcements = Announcement::where('is_active', true)
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }
}
