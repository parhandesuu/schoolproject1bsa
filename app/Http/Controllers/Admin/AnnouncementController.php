<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'file'       => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'type'       => 'required|in:info,warning,success,danger',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'is_active'  => 'boolean',
            'is_pinned'  => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_pinned'] = $request->boolean('is_pinned');

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('announcements', 'public');
            $validated['file'] = $path;
        }

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement created successfully.');
    }

    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'file'       => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'type'       => 'required|in:info,warning,success,danger',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'is_active'  => 'boolean',
            'is_pinned'  => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_pinned'] = $request->boolean('is_pinned');

        if ($request->hasFile('file')) {
            if ($announcement->file) {
                Storage::disk('public')->delete($announcement->file);
            }
            $path = $request->file('file')->store('announcements', 'public');
            $validated['file'] = $path;
        }

        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->file) {
            Storage::disk('public')->delete($announcement->file);
        }
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement deleted successfully.');
    }
}
