<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController as FrontProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ExtracurricularController;

// ===========================
// PUBLIC ROUTES
// ===========================
Route::get('/', [HomeController::class, 'index'])->name('home');

// Profil
Route::prefix('profil')->name('profile.')->group(function () {
    Route::get('/', [FrontProfileController::class, 'index'])->name('index');
    Route::get('/sejarah', [FrontProfileController::class, 'history'])->name('history');
    Route::get('/visi-misi', [FrontProfileController::class, 'visionMission'])->name('vision-mission');
    Route::get('/sambutan-kepala-sekolah', [FrontProfileController::class, 'principal'])->name('principal');
    Route::get('/struktur-organisasi', [FrontProfileController::class, 'organization'])->name('organization');
});

// Akademik
Route::get('/guru-staff', [TeacherController::class, 'index'])->name('teachers.index');
Route::get('/fasilitas', [FacilityController::class, 'index'])->name('facilities.index');
Route::get('/prestasi', [AchievementController::class, 'index'])->name('achievements.index');
Route::get('/ekstrakurikuler', [ExtracurricularController::class, 'index'])->name('extracurriculars.index');

// Berita
Route::get('/berita', [PostController::class, 'index'])->name('posts.index');
Route::get('/berita/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::post('/berita/{post:slug}/komentar', [PostController::class, 'storeComment'])->name('posts.comment');

// Agenda & Pengumuman
Route::get('/agenda', [AgendaController::class, 'index'])->name('agendas.index');
Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('announcements.index');

// Galeri
Route::get('/galeri/foto', [GalleryController::class, 'photos'])->name('gallery.photos');
Route::get('/galeri/foto/{album}', [GalleryController::class, 'album'])->name('gallery.album');
Route::get('/galeri/video', [GalleryController::class, 'videos'])->name('gallery.videos');

// Download
Route::get('/download', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/download/{document}', [DocumentController::class, 'download'])->name('documents.download');

// Layanan
Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');

// Kontak
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

// ===========================
// AUTH ROUTES (Breeze)
// ===========================
require __DIR__.'/auth.php';

// ===========================
// ADMIN ROUTES
// ===========================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Hero Sliders
    Route::resource('hero-sliders', \App\Http\Controllers\Admin\HeroSliderController::class);

    // Logos
    Route::resource('logos', \App\Http\Controllers\Admin\LogoController::class);

    // Pages (Profil, Sejarah, Visi Misi, Sambutan, Struktur)
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

    // Guru & Staff
    Route::resource('teachers', \App\Http\Controllers\Admin\TeacherController::class);

    // Fasilitas
    Route::resource('facilities', \App\Http\Controllers\Admin\FacilityController::class);

    // Prestasi
    Route::resource('achievements', \App\Http\Controllers\Admin\AchievementController::class);

    // Ekstrakurikuler
    Route::resource('extracurriculars', \App\Http\Controllers\Admin\ExtracurricularController::class);

    // Berita & Kategori
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);

    // Komentar
    Route::get('comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');
    Route::patch('comments/{comment}/approve', [\App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('comments.approve');
    Route::patch('comments/{comment}/reject', [\App\Http\Controllers\Admin\CommentController::class, 'reject'])->name('comments.reject');
    Route::delete('comments/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comments.destroy');

    // Agenda
    Route::resource('agendas', \App\Http\Controllers\Admin\AgendaController::class);

    // Pengumuman
    Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class);

    // Galeri Foto
    Route::resource('photo-albums', \App\Http\Controllers\Admin\PhotoAlbumController::class);
    Route::resource('photo-albums.photos', \App\Http\Controllers\Admin\PhotoGalleryController::class)->shallow();

    // Galeri Video
    Route::resource('video-galleries', \App\Http\Controllers\Admin\VideoGalleryController::class);

    // Dokumen
    Route::resource('documents', \App\Http\Controllers\Admin\DocumentController::class);

    // Layanan
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);

    // Kontak Masuk
    Route::get('contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::patch('contacts/{contact}/read', [\App\Http\Controllers\Admin\ContactController::class, 'markRead'])->name('contacts.read');
    Route::delete('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

    // Statistik
    Route::resource('statistics', \App\Http\Controllers\Admin\StatisticController::class);

    // Social Media
    Route::resource('social-media', \App\Http\Controllers\Admin\SocialMediaController::class);

    // Pengaturan
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Users
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Profile Admin
    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password');
});
