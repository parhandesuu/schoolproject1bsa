<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * Display a paginated list of active achievements.
     * Supports filtering by level, category, and year.
     */
    public function index(Request $request)
    {
        $query = Achievement::where('is_active', true)
            ->latest();

        // Filter by level (e.g., sekolah, kecamatan, kabupaten/kota, provinsi, nasional, internasional)
        if ($request->filled('level')) {
            $level = trim($request->input('level'));
            if ($level === 'Kabupaten/Kota' || $level === 'Kabupaten') {
                $query->whereIn('level', ['Kabupaten/Kota', 'Kabupaten', 'Kota']);
            } else {
                $query->where('level', 'like', "%{$level}%");
            }
        }

        // Filter by category (e.g., akademik, non-akademik, olahraga, seni)
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->where('year', $request->input('year'));
        }

        $achievements = $query->paginate(12)->withQueryString();

        // Distinct levels for filter dropdown
        $levels = Achievement::where('is_active', true)
            ->select('level')
            ->distinct()
            ->orderBy('level')
            ->pluck('level');

        // Distinct categories for filter dropdown
        $categories = Achievement::where('is_active', true)
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Distinct years for filter dropdown
        $years = Achievement::where('is_active', true)
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('achievements.index', compact('achievements', 'levels', 'categories', 'years'));
    }
}
