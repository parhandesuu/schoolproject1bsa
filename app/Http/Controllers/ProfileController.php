<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the general profile page.
     */
    public function index()
    {
        $page = Page::where('slug', 'profil')
            ->where('is_active', true)
            ->firstOrFail();

        return view('profile.index', compact('page'));
    }

    /**
     * Display the school history page.
     */
    public function history()
    {
        $page = Page::where('slug', 'sejarah')
            ->where('is_active', true)
            ->firstOrFail();

        return view('profile.history', compact('page'));
    }

    /**
     * Display the vision and mission page.
     */
    public function visionMission()
    {
        $page = Page::where('slug', 'visi-misi')
            ->where('is_active', true)
            ->firstOrFail();

        return view('profile.vision-mission', compact('page'));
    }

    /**
     * Display the principal's greeting page.
     */
    public function principal()
    {
        $page = Page::where('slug', 'sambutan-kepala-sekolah')
            ->where('is_active', true)
            ->firstOrFail();

        // Load teacher with position containing 'Kepala'
        $principal = Teacher::where('is_active', true)
            ->where('position', 'like', '%Kepala%')
            ->first();

        return view('profile.principal', compact('page', 'principal'));
    }

    /**
     * Display the organizational structure page.
     */
    public function organization()
    {
        $page = Page::where('slug', 'struktur-organisasi')
            ->where('is_active', true)
            ->firstOrFail();

        $principal = Teacher::where('is_active', true)
            ->where('position', 'like', '%Kepala%')
            ->first();

        $staff = Teacher::where('is_active', true)->get();

        return view('profile.organization', compact('page', 'principal', 'staff'));
    }
}
