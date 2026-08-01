<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display all active facilities.
     */
    public function index()
    {
        $facilities = Facility::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return view('facilities.index', compact('facilities'));
    }
}
