<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Extracurricular;
use App\Models\HeroSlider;
use App\Models\Logo;
use App\Models\Page;
use App\Models\PhotoAlbum;
use App\Models\Post;
use App\Models\Service;
use App\Models\SocialMedia;
use App\Models\Statistic;
use App\Models\Teacher;
use App\Models\VideoGallery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with all relevant data.
     */
    public function index()
    {
        // Hero sliders - active only
        $hero_sliders = HeroSlider::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Pages for profil and sambutan sections
        $profilePage = Page::where('slug', 'profil')
            ->where('is_active', true)
            ->first();

        $sambutanPage = Page::where('slug', 'sambutan-kepala-sekolah')
            ->where('is_active', true)
            ->first();

        // Principal (Kepala Sekolah) from Teacher data
        $principal = Teacher::where('is_active', true)
            ->where('position', 'like', '%Kepala%')
            ->first();

        // Statistics - active only
        $statistics = Statistic::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Posts - published, latest 6
        $posts = Post::where('status', 'published')
            ->with('category')
            ->latest('published_at')
            ->take(6)
            ->get();

        // Agendas - upcoming 4 (start_date >= today)
        $agendas = Agenda::where('is_active', true)
            ->where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date')
            ->take(4)
            ->get();

        // Announcements - active, pinned first, latest 5
        $announcements = Announcement::where('is_active', true)
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Achievements - active, latest 6
        $achievements = Achievement::where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        // Extracurriculars - active, 6
        $extracurriculars = Extracurricular::where('is_active', true)
            ->orderBy('order')
            ->take(6)
            ->get();

        // Photo albums - active, 6, with first photo eager loaded
        $photo_albums = PhotoAlbum::where('is_active', true)
            ->with(['photos' => function ($query) {
                $query->orderBy('order');
            }])
            ->withCount('photos')
            ->latest()
            ->take(6)
            ->get();

        // Video galleries - active, 3
        $video_galleries = VideoGallery::where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        // Services - active, 6
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->take(6)
            ->get();

        // Social media - active
        $social_media = SocialMedia::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('home.index', compact(
            'hero_sliders',
            'profilePage',
            'sambutanPage',
            'principal',
            'statistics',
            'posts',
            'agendas',
            'announcements',
            'achievements',
            'extracurriculars',
            'photo_albums',
            'video_galleries',
            'services',
            'social_media'
        ));
    }
}
